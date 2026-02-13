# Modernize Employee Management

## Goal Description
Modernize employee-related pages (`empinfo.php`, `salary.php`, `addemp.php`) by extracting logic into an `EmployeeService` and updating the UI with Tailwind CSS.

## Proposed Changes

### Logic Extraction
#### [NEW] [EmployeeService.php](file:///c:/xampp/htdocs/TempApps/NadirCom7726_VibeCoded/src/Services/EmployeeService.php)
-   `getAllEmployees(): array`: Fetch all employees from `empinfo`.
-   `getEmployeeById(int $id): ?array`: Fetch single employee details.
-   `calculateSalary($empId, $month): float`: Handle complex salary aggregation.

### UI/UX Modernization
#### [MODIFY] [empinfo.php](file:///c:/xampp/htdocs/TempApps/NadirCom7726_VibeCoded/admin/empinfo.php)
-   Update to use `EmployeeService`.
-   Modern Tailwind table with search and filters (if applicable).
-   Consistent layout with Nav and Header.

## Verification Plan
-   Create `verify_employee_service.php` to test data retrieval.
-   Manual verification of the UI.
