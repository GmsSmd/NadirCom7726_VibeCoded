NadirCom7726 — Full Codebase Analysis
Application Overview
NadirCom7726 is a Franchise Management System (FMS) built for a Jazz (telecom) franchise in Pakistan. It manages the day-to-day operations of a mobile phone franchise, including sales of mobile load (Otar), JazzCash/MFS (Mobile Financial Services), scratch cards, SIMs, and mobile devices. The system tracks inventory, sales, payments, receivables, salaries, expenses, targets, commissions, and investments.

Tech Stack: Raw PHP (no framework), MySQLi, HTML tables, vanilla CSS, minimal JavaScript
PHP Version: 7.4 (per 
php.ini
 session path)
Database: MySQL (nadircom7726 on localhost)
Architecture: Procedural PHP with include-based modularity, no MVC or OOP patterns
Project Structure
NadirCom7726/
├── index.php              # Login page (entry point)
├── login.php              # Login logic (authentication)
├── logout.php             # Session destroy + redirect
├── session.php            # Session validation guard
├── php.ini                # PHP config (cPanel-generated)
└── admin/                 # All app functionality
    ├── summary.php        # Dashboard (933 lines, role-based views)
    ├── dosales.php         # Sales sheet per employee (827 lines)
    ├── do.php              # Older sales module
    ├── dorecord.php        # Receivable records
    ├── dodues.php          # DO advance management
    ├── lifting.php         # Purchase/lifting entries
    ├── stock.php           # Stock reports
    ├── monthclosing.php    # Monthly closing procedures
    ├── ws.php              # Wholeseller management
    ├── mfsupload.php       # MFS sheet upload
    ├── mfsupload_iq.php    # MFS initiator query
    ├── ... (76 PHP files total)
    ├── includes/           # Core shared logic (24 files)
    │   ├── dbcon.php           # DB connection
    │   ├── globalvar.php       # Config vars + calcStocks()
    │   ├── variables.php       # Session, dates, rates
    │   ├── navbar.php          # Main navigation (role-based)
    │   ├── getsummary.php      # Summary calculations (992 lines)
    │   ├── formula.php         # Target, product type, MFS formulas
    │   ├── doformula.php       # Sales entry formulas
    │   ├── creditcalculation.php
    │   ├── stockcalculation.php
    │   ├── receiptformula.php  # Receipt calculations (45K)
    │   ├── dailyactivityfunctions.php  # Daily activity (47K)
    │   ├── oldactivityfunctions.php    # Old activity (47K)
    │   ├── openclose.php       # Opening/closing calculations
    │   ├── wsformula.php       # Wholeseller formulas
    │   └── ... (10 more files)
    ├── delete/             # Delete handlers (36 files)
    │   ├── delcard.php, delemp.php, delmfs.php, ...
    ├── edit/               # Edit handlers (15 files)
    │   ├── editemp.php, editrt.php, editws.php, ...
    ├── styles/             # CSS/styling (5 files)
    │   ├── loginstyle.css
    │   ├── navbarstyle.php
    │   └── tablestyle.php
    └── resources/          # Assets
        └── jazznew.PNG         # Jazz brand logo
Core Data Flow
Login (index.php)
Session Check (session.php)
Dashboard (summary.php)
Sales (dosales.php)
Purchases (lifting.php)
Payments / Receipts
Reports (stock, bank, expenses)
Management (users, employees, products)
DB: tbl_mobile_load, tbl_financial_service, tbl_cards, tbl_product_stock
DB: receiptpayment, comission
DB: empinfo, users, config, types, rates
Database Tables (inferred from queries)
Table	Purpose
users	Login credentials (username, password, user_type)
config	System config (company name, organization, default bank, product labels)
empinfo	Employee records (name, salary, status, sort order, commission rates)
tbl_mobile_load	Mobile load (Otar) transactions
tbl_financial_service	JazzCash/MFS transactions
tbl_cards	Scratch card transactions
tbl_product_stock	SIM & mobile device stock
receiptpayment	All receipts and payments
comission	Commission records (MFS, Other, Activity, etc.)
openingclosing	Monthly opening/closing balances
target	Monthly sales targets
rates	Purchase and sale prices
types	Product sub-types (Card Rs.100, SIM types, etc.)
fixedexp	Fixed monthly expenses
regularexp	Daily regular expenses
rpmode	Payment modes (bank names, cash)
invest	Investment/withdrawal records
User Roles & Access Control
Role	Access Level
Admin	Full access: financial visibility, profitability, employee management, all reports
Manager	Same as Admin but no employee CRUD, sees a pared-down summary
Clerk	Target tracking only, sees investment/dues but no profit visibility
Role checks are done inline via $currentUserType from the session. The 
navbar.php
 conditionally shows/hides menu items based on role.

Key Functional Modules
Module	Files	Description
Dashboard	
summary.php
, 
getsummary.php
Shows targets vs. achievements, daily Otar/MFS/Card breakdown, investment overview, visibility
Sales	
dosales.php
, 
doformula.php
, 
do.php
Per-employee daily sales sheet with load, MFS, cards, SIMs, devices, receivables
Purchases	
lifting.php
Record stock purchases from parent company
Payments	
payments.php
, 
receipts.php
, 
companypayment.php
Record and view payments/receipts across all heads
Salary	
paysalary.php
, 
currentsalary.php
, 
salarydeduction.php
, 
salary_adjust.php
Calculate and pay monthly salaries with commissions
Stock	
stock.php
, 
stockcalculation.php
Opening + Purchases − Sales = Closing for all product types
Expenses	
expenses.php
, 
expensesfix.php
, 
expensereport.php
Track daily and fixed expenses
Commission	
getcomission.php
, 
paycomission.php
Receive and distribute commissions
Reports	
bankstatement.php
, 
purchasesummary.php
, 
salesummary.php
, 
rpsummary.php
, rpt*.php	Various financial reports and receivable breakdowns
Month Close	
monthclosing.php
, 
openingclosing.php
, 
initialoc.php
Monthly closing procedures, set opening balances
Management	
addusers.php
, 
addemp.php
, 
addproduct.php
, 
addcompany.php
, 
addws.php
, 
addrt.php
CRUD for users, employees, products, companies, wholesellers, retailers
Security Issues Identified
CAUTION

Critical security vulnerabilities found throughout the codebase:

#	Issue	Severity	Details
1	Plaintext passwords	🔴 Critical	Passwords stored and compared as plaintext in 
login.php
 — no hashing
2	SQL Injection	🔴 Critical	$_GET['name'] used directly in queries (e.g., 
dosales.php
 line 5, $Employee = $_GET['name']). POST data in 
formula.php
 inserted directly into SQL
3	No CSRF protection	🟠 High	No CSRF tokens on any forms
4	XSS vulnerabilities	🟠 High	User input echoed directly into HTML without htmlspecialchars()
5	Session fixation	🟡 Medium	No session_regenerate_id() after login
6	Exposed DB credentials	🟠 High	Server credentials commented out but still visible in 
dbcon.php
 (line 2)
7	Error suppression	🟡 Medium	ini_set('error_reporting', '0') hides all errors in production
8	No input validation	🟠 High	No type checking or sanitization on numeric inputs (amounts, quantities)
9	Direct file deletion	🟡 Medium	Delete scripts execute DELETE FROM with minimal validation
10	allow_url_include = On	🟠 High	Enabled in 
php.ini
, can enable remote file inclusion attacks
Code Quality Issues
#	Issue	Impact
1	Massive file sizes — 
getsummary.php
 (992 lines), 
summary.php
 (933 lines), 
dosales.php
 (827 lines)	Extremely hard to maintain
2	Massive code duplication — Admin/Manager/Clerk views in 
summary.php
 are nearly identical copy-pasted blocks	Any change must be made 3 times
3	HTML inside <style> tags — 
navbar.php
 is included inside <style> blocks (e.g. 
summary.php
 line 21)	Invalid HTML, works by browser tolerance
4	Hundreds of individual SQL queries per page — 
getsummary.php
 runs 50+ queries, 
summary.php
 runs queries inside a daily loop	Very slow page loads
5	No separation of concerns — Business logic, DB queries, and HTML rendering mixed in every file	Untestable, unmaintainable
6	Deprecated functions — strftime() used in 
variables.php
 (deprecated since PHP 8.1)	Will break on upgrade
7	Hardcoded business values — Product names like "Rs.100", "Card", "Otar" hardcoded throughout queries	Fragile, hard to change
8	Inconsistent naming — Mix of camelCase, no-case, abbreviations ($tmptxtAmntReceived, $Data2222, $q2555)	Hard to read
9	No error handling — or die(mysqli_query()) is used everywhere, which itself is invalid (should be mysqli_error())	Produces empty die() messages
10	Session key typo — 
login.php
 line 35: $_SESSION['default_bank']` has a backtick in the key name	Bug — default bank may never be correctly stored in session
Potential Bugs Found
#	Bug	Location
1	Session key 'default\_bank'` has backtick character	
login.php
2	$FrOtartarge (missing 't') referenced before it's defined	
getsummary.php
3	or die(mysqli_query()) — calling mysqli_query() with no args in die handler	Throughout entire codebase
4	Date looping via $i+=86400 (adding seconds) will fail during DST transitions	
summary.php
, 
dosales.php
5	$slAmnt21 computed with wrong variables ($qt2*$rt2 instead of $qt21*$rt21)	
dosales.php
Summary
This is a functional but aging legacy PHP application with significant technical debt. It works for its intended purpose (telecom franchise management) but has critical security vulnerabilities, no code organization patterns, massive code duplication, and performance issues from excessive database queries. The UI is functional but basic (HTML tables with minimal CSS).