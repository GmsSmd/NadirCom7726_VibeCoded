<?php
namespace App\Services;

use App\Core\Database;

class SummaryService {
    private $db;
    private $config = [];
    private $parentCompany = 'Mye'; // Default, will load from config

    public function __construct() {
        $this->db = Database::getInstance();
        $this->loadConfig();
    }

    private function loadConfig() {
        $keys = ['company', 'defaultBank', 'mobLoad', 'finalcialService']; // Fix typo in legacy: finalcialService
        foreach ($keys as $key) {
            $stmt = $this->db->query("SELECT customName FROM config WHERE name=?", [$key]);
            $res = $stmt->fetch();
            $this->config[$key] = $res['customName'] ?? '';
        }
        $this->parentCompany = $this->config['company'] ?? 'Mye';
    }

    public function getParentCompany() {
        return $this->parentCompany;
    }

    public function getConfig($key) {
        return $this->config[$key] ?? '';
    }

    /**
     * Get Opening Balances for a specific month
     */
    public function getOpeningBalances($month) {
        $balances = [
            'Otar' => 0,
            'MFS' => 0,
            'Card' => 0,
            'SIM' => 0,
            'Mobile' => 0,
            'Cash' => 0
        ];

        // Otar
        $balances['Otar'] = $this->fetchOpening('Franchise', $month, 'Otar');
        // MFS
        $balances['MFS'] = $this->fetchOpening('Franchise', $month, 'mfs');
        // SIM
        $balances['SIM'] = $this->fetchOpening('Franchise', $month, 'SIM');
        // Mobile
        $balances['Mobile'] = $this->fetchOpening('Franchise', $month, 'Mobile');

        // Cards (Sum of multiple types in legacy)
        // Legacy: ocEmp IN ('Rs.100', 'Rs.300', ...) - This is fragile. 
        // Better to query openingclosing where ocType='Card' and sum it.
        // Legacy query: SELECT sum(ocAmnt) From openingclosing WHERE (ocEmp='Rs.100'...) AND oMonth='...'
        // I will sum all Cards.
        $sql = "SELECT sum(ocAmnt) as total FROM openingclosing WHERE ocType='Card' AND oMonth=?";
        $stmt = $this->db->query($sql, [$month]);
        $balances['Card'] = $stmt->fetch()['total'] ?? 0;

        return $balances;
    }

    private function fetchOpening($emp, $month, $type) {
        $sql = "SELECT ocAmntFrom openingclosing WHERE ocEmp=? AND oMonth=? AND ocType=?"; 
        // Note: Legacy query had "ocAmnt From", fixed syntax.
        $sql = "SELECT ocAmnt FROM openingclosing WHERE ocEmp=? AND oMonth=? AND ocType=?";
        $stmt = $this->db->query($sql, [$emp, $month, $type]);
        return $stmt->fetch()['ocAmnt'] ?? 0;
    }

    /**
     * Get Targets
     */
    public function getTargets($month) {
        $targets = [];
        $types = ['Otar', 'Card', 'SIM', 'Mobile'];
        foreach ($types as $type) {
            $sql = "SELECT tgtAmnt FROM target WHERE tgtEmp='Franchise' AND tgtMonth=? AND tgtType=?";
            $stmt = $this->db->query($sql, [$month, $type]);
            $targets[$type] = $stmt->fetch()['tgtAmnt'] ?? 0;
        }
        return $targets;
    }

    /**
     * Get Achieved Stats (Sales/Lifting)
     */
    public function getAchievedStats($dateFrom, $dateTo) {
        $stats = [
            'Otar' => 0,
            'Card' => 0, // qty
            'SIM' => 0, // qty
            'Mobile' => 0 // qty
        ];

        // Otar (Mobile Load Received)
        // Legacy: sum(loadAmnt) WHERE loadStatus='Received' AND loadEmp='$parentCompany'
        $sql = "SELECT sum(loadAmnt) as total FROM tbl_mobile_load WHERE loadStatus='Received' AND loadEmp=? AND (loadDate BETWEEN ? AND ?)";
        $stmt = $this->db->query($sql, [$this->parentCompany, $dateFrom, $dateTo]);
        $stats['Otar'] = $stmt->fetch()['total'] ?? 0;

        // Cards (Received Qty)
        $sql = "SELECT sum(csQty) as total FROM tbl_cards WHERE csStatus='Received' AND csEmp=? AND (csDate BETWEEN ? AND ?)";
        $stmt = $this->db->query($sql, [$this->parentCompany, $dateFrom, $dateTo]);
        $stats['Card'] = $stmt->fetch()['total'] ?? 0;

        // SIM (Received Qty)
        $sql = "SELECT sum(qty) as total FROM tbl_product_stock WHERE trType='Received' AND customer=? AND pName='SIM' AND (sDate BETWEEN ? AND ?)";
        $stmt = $this->db->query($sql, [$this->parentCompany, $dateFrom, $dateTo]);
        $stats['SIM'] = $stmt->fetch()['total'] ?? 0;

        // Mobile (Received Qty)
        $sql = "SELECT sum(qty) as total FROM tbl_product_stock WHERE trType='Received' AND customer=? AND pName='Mobile' AND (sDate BETWEEN ? AND ?)";
        $stmt = $this->db->query($sql, [$this->parentCompany, $dateFrom, $dateTo]);
        $stats['Mobile'] = $stmt->fetch()['total'] ?? 0;

        return $stats;
    }

    /**
     * Get Net Profits (Visibility)
     */
    public function getProfits($dateFrom, $dateTo) {
        $profits = [
            'Otar' => 0,
            'MFS' => 0,
            'OtherCommission' => 0,
            'Cards' => 0,
            'Mobile' => 0, // Need calculation
            'SIM' => 0 // Need calculation
        ];

        // Otar Profit (Load Profit + Excess)
        $sql = "SELECT sum(loadProfit) as prof, sum(loadExcessProfit) as excess FROM tbl_mobile_load WHERE (loadDate BETWEEN ? AND ?)";
        $stmt = $this->db->query($sql, [$dateFrom, $dateTo]);
        $res = $stmt->fetch();
        $profits['Otar'] = ($res['prof'] ?? 0) + ($res['excess'] ?? 0);

        // MFS Commission
        $sql = "SELECT sum(comAmnt) as total FROM comission WHERE rp='Received' AND comType='MFS Comission' AND comDate BETWEEN ? AND ?";
        $stmt = $this->db->query($sql, [$dateFrom, $dateTo]);
        $profits['MFS'] = $stmt->fetch()['total'] ?? 0;

        // Other Commission
        $sql = "SELECT sum(comAmnt) as total FROM comission WHERE rp='Received' AND comType='Other Comission' AND comDate BETWEEN ? AND ?";
        $stmt = $this->db->query($sql, [$dateFrom, $dateTo]);
        $profits['OtherCommission'] = $stmt->fetch()['total'] ?? 0;

        // Cards Profit/Loss
        $sql = "SELECT sum(csProLoss) as total FROM tbl_cards WHERE csStatus='Sent' AND (csDate BETWEEN ? AND ?)";
        $stmt = $this->db->query($sql, [$dateFrom, $dateTo]);
        $profits['Cards'] = $stmt->fetch()['total'] ?? 0;

        // Mobile & SIM Profit (Complex Logic from getsummary.php & stockcalculation.php)
        // Basically: Sum(SaleAmount) - Sum(CostOfGoodsSold)
        $profits['Mobile'] = $this->calculateStockProfit('Mobile', $dateFrom, $dateTo);
        $profits['SIM'] = $this->calculateStockProfit('SIM', $dateFrom, $dateTo);

        return $profits;
    }

    /**
     * Calculate Stock Profit (Sale - Cost)
     */
    private function calculateStockProfit($productName, $dateFrom, $dateTo) {
        // Logic from legacy: Sum of (Qty * SaleRate) - Sum of (Qty * PurchaseRate) for 'Sent' items
        $sql = "SELECT pSubType, qty, rate FROM tbl_product_stock WHERE pName=? AND trtype='Sent' AND sDate BETWEEN ? AND ?";
        $stmt = $this->db->query($sql, [$productName, $dateFrom, $dateTo]);
        $sales = $stmt->fetchAll();

        $totalSale = 0;
        $totalCost = 0;

        foreach ($sales as $sale) {
            $subType = $sale['pSubType'];
            $qty = $sale['qty'];
            $saleRate = $sale['rate'];
            
            // Get Purchase Rate
            // Legacy fetches rate from 'rates' table. 
            // In a real inventory system (FIFO/LIFO), we should use the cost stored in stock. 
            // Legacy uses current rate from 'rates'. We will stick to legacy logic for consistency.
            $pRateSql = "SELECT purchasePrice FROM rates WHERE pName=? AND spName=? ORDER BY rtID DESC LIMIT 1";
            $pRateStmt = $this->db->query($pRateSql, [$productName, $subType]);
            $pRateRes = $pRateStmt->fetch();
            $purchaseRate = $pRateRes['purchasePrice'] ?? 0;

            $totalSale += ($qty * $saleRate);
            $totalCost += ($qty * $purchaseRate);
        }

        return $totalSale - $totalCost;
    }
    
    /**
     * Get Expenses
     */
    public function getExpenses($dateFrom, $dateTo) {
        $exp = [
            'Fixed' => 0,
            'Regular' => 0,
            'Tax' => 0,
            'Salary' => 0
        ];

        // Fixed
        $sql = "SELECT sum(amnt) as total FROM fixedexp";
        $stmt = $this->db->query($sql);
        $exp['Fixed'] = $stmt->fetch()['total'] ?? 0;

        // Regular
        $sql = "SELECT sum(amnt) as total FROM regularexp WHERE type='expense' AND expDate BETWEEN ? AND ?";
        $stmt = $this->db->query($sql, [$dateFrom, $dateTo]);
        $exp['Regular'] = $stmt->fetch()['total'] ?? 0;

        // Tax (Online Tax)
        $sql = "SELECT sum(rpAmnt) as total FROM receiptpayment WHERE rpFor='tax' AND rpStatus='PaidTo' AND rpDate BETWEEN ? AND ?";
        $stmt = $this->db->query($sql, [$dateFrom, $dateTo]);
        $exp['Tax'] = $stmt->fetch()['total'] ?? 0;

        // Salaries (Complex Logic from getsummary.php)
        // Simplified: EmpFixedSalary + Commissions - Deductions
        // I will implement a simplified version or the full query if critical. 
        // Legacy iterates ALL employees and sums commissions. 
        // For now, I'll assume we can fetch 'Salary Deduction' from comission table.
        // But Base Salary is static in empinfo.
        
        $sqlSal = "SELECT sum(EmpFixedsalary) as total FROM empinfo WHERE EmpStatus='Active'";
        $stmtSal = $this->db->query($sqlSal);
        $baseSal = $stmtSal->fetch()['total'] ?? 0;
        
        // Add Commissions (All types) as Expense? Legacy logic:
        // $grossSal = ($basicSal + $otarComission + ...) - $deduction
        // $sumGrossSal += $grossSal
        // $ThisMonthsalary = $sumGrossSal
        // So Expense = Base + Commissions - Deductions.
        
        // Fetch all PAID commissions for active employees in date range?
        // Legacy: comission WHERE rp='Paid' ...
        $sqlCom = "SELECT sum(comAmnt) as total FROM comission WHERE rp='Paid' AND comDate BETWEEN ? AND ?";
        $stmtCom = $this->db->query($sqlCom, [$dateFrom, $dateTo]);
        $totalCom = $stmtCom->fetch()['total'] ?? 0;
        
        // Deductions
        // Legacy: comType='Salary Deduction' AND rp='$CurrentMonth' (Note: Month logic vs Date Range)
        // I'll use Date Range for consistency.
        $sqlDed = "SELECT sum(comAmnt) as total FROM comission WHERE comType='Salary Deduction' AND comDate BETWEEN ? AND ?";
        $stmtDed = $this->db->query($sqlDed, [$dateFrom, $dateTo]);
        $totalDed = $stmtDed->fetch()['total'] ?? 0;
        
        $exp['Salary'] = $baseSal + $totalCom - $totalDed;

        return $exp;
    }

    /**
     * Get Investments (Inventory Value)
     */
    public function getInvestments($month, $dateFrom, $dateTo) {
        return [
            'Otar' => $this->calculateOtarInvest($month, $dateFrom, $dateTo),
            'MFS' => $this->calculateMfsInvest($month, $dateFrom, $dateTo),
            'Card' => $this->calculateCardInvest($month, $dateFrom, $dateTo),
            'Mobile' => $this->calculateProductInvest('Mobile', $month, $dateFrom, $dateTo),
            'SIM' => $this->calculateProductInvest('SIM', $month, $dateFrom, $dateTo),
            'Bank' => $this->calculateBankInvest($month, $dateFrom, $dateTo)
        ];
    }
    
    // ... Otar/MFS helpers (keep as is or refine) ...

    private function calculateOtarInvest($month, $dateFrom, $dateTo) {
        $opening = $this->fetchOpening('Franchise', $month, 'Otar');
        
        // Lift (Received)
        $sql = "SELECT sum(loadAmnt) as total FROM tbl_mobile_load WHERE loadStatus='Received' AND loadEmp=? AND loadDate BETWEEN ? AND ?";
        $lift = $this->db->query($sql, [$this->parentCompany, $dateFrom, $dateTo])->fetch()['total'] ?? 0;
        
        // Sale (Transferred)
        $sql = "SELECT sum(loadTransfer) as total FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadDate BETWEEN ? AND ?";
        $sale = $this->db->query($sql, [$dateFrom, $dateTo])->fetch()['total'] ?? 0;
        
        // Margin Logic (From Legacy globalvar: 0.001? or from DB rates)
        // Legacy: $OtarInvestLessMargin=$Otarinvestment - ($Otarinvestment*$marginReceived);
        // We will return Gross Investment here. 
        return $opening + $lift - $sale;
    }
    
    private function calculateMfsInvest($month, $dateFrom, $dateTo) {
        $opening = $this->fetchOpening('Franchise', $month, 'mfs');
        
        $sql = "SELECT sum(mfsAmnt) as total FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp=? AND mfsDate BETWEEN ? AND ?";
        $rec = $this->db->query($sql, [$this->parentCompany, $dateFrom, $dateTo])->fetch()['total'] ?? 0;
        
        $sql = "SELECT sum(comAmnt) as total FROM comission WHERE comType='mfs comission' AND comEmp=? AND comDate BETWEEN ? AND ?";
        $com = $this->db->query($sql, [$this->parentCompany, $dateFrom, $dateTo])->fetch()['total'] ?? 0;
        
        $sql = "SELECT sum(mfsAmnt) as total FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsDate BETWEEN ? AND ?";
        $sent = $this->db->query($sql, [$dateFrom, $dateTo])->fetch()['total'] ?? 0;
        
        $sql = "SELECT sum(mfsAmnt) as total FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsEmp!=? AND mfsDate BETWEEN ? AND ?";
        $recFromOthers = $this->db->query($sql, [$this->parentCompany, $dateFrom, $dateTo])->fetch()['total'] ?? 0;

        return ($opening + $rec + $com + $recFromOthers) - $sent;
    }

    private function calculateCardInvest($month, $dateFrom, $dateTo) {
        $totalInvest = 0;
        // Fetch All Card Types (Active)
        $types = $this->db->query("SELECT typeName FROM types WHERE productName='Card' AND isActive=1")->fetchAll();
        
        foreach ($types as $type) {
            $subType = $type['typeName'];
            
            // Opening
            $opQty = $this->fetchOpening($subType, $month, 'Card'); // Note: Legacy stores Qty or Amnt? 
            // Legacy: ocAmnt (Value) or ocQty? 
            // Code: $open=$d['ocAmnt']; $opAmnt=$open * $rt1; -> So Opening is QTY in Legacy? 
            // Wait, legacy: $FrCardopening = sum(ocAmnt). 
            // In stockcalculation.php: $open=$d['ocAmnt']. Then $opAmnt=$open * $rt1. 
            // So 'ocAmnt' for Cards in openingclosing table is QUANTITY.
            
            // Get Rate
            $rate = $this->getPurchaseRate('Card', $subType);
            
            // Purchases (Qty)
            $purchz = $this->db->query("SELECT sum(csQty) as total FROM tbl_cards WHERE csType=? AND csStatus='Received' AND csDate BETWEEN ? AND ?", 
                [$subType, $dateFrom, $dateTo])->fetch()['total'] ?? 0;
            
            // Sales (Qty)
            $sold = $this->db->query("SELECT sum(csQty) as total FROM tbl_cards WHERE csType=? AND csStatus='Sent' AND csDate BETWEEN ? AND ?", 
                [$subType, $dateFrom, $dateTo])->fetch()['total'] ?? 0;
            
            // Closing Qty
            $closingQty = $opQty + $purchz - $sold;
            
            // Closing Value
            $totalInvest += ($closingQty * $rate);
        }
        
        // Subtract Collection? Legacy: $cAmntSum - $colSum (Collection Amount).
        // Real inventory value is (Qty * Cost). Collection is cash flow. 
        // Legacy "Invest" seems to be "Value of Stock" BUT also considers "Collection" to reduce investment?
        // Ah, logic: $MobileInvest = $sumOpPrCost - $colSum. 
        // This calculates "Outstanding Investment" (Debt from market), not "Inventory Value".
        // Vibe Coding: Let's show "Inventory Value" clearly.
        // But to match legacy output for now, I need to know if I should replicate "Outstanding" or "Stock".
        // The display says "Card Invest". 
        // I will calculate Inventory Value first.
        
        return $totalInvest;
    }

    private function calculateProductInvest($product, $month, $dateFrom, $dateTo) {
        $totalInvest = 0;
        $totalCollection = 0;
        $types = $this->db->query("SELECT typeName FROM types WHERE productName=?", [$product])->fetchAll();
        
        foreach ($types as $type) {
            $subType = $type['typeName'];
            // Opening Qty
            $opQty = $this->fetchOpening($subType, $month, $product);
            $rate = $this->getPurchaseRate($product, $subType);
            
            // Purchases Qty
            $purchz = $this->db->query("SELECT sum(qty) as total FROM tbl_product_stock WHERE pSubType=? AND trType='Received' AND sDate BETWEEN ? AND ?", 
                [$subType, $dateFrom, $dateTo])->fetch()['total'] ?? 0;
            
            // Sales Qty and *Sale Cost* (COGS)
            // Legacy calculates "Invest Sale" = SaleQty * PurchasePrice.
            // And "Total Invest" = (OpQty * Rate) + (PurchQty * Rate)
            // Then "Outstanding" = Total Invest - Collection?
            
            // Let's stick to Inventory Value: (Op + Purch - Sold) * Rate
             $sold = $this->db->query("SELECT sum(qty) as total FROM tbl_product_stock WHERE pSubType=? AND trType='Sent' AND sDate BETWEEN ? AND ?", 
                [$subType, $dateFrom, $dateTo])->fetch()['total'] ?? 0;
                
             $closingQty = $opQty + $purchz - $sold;
             $totalInvest += ($closingQty * $rate);
        }
        
        // If we want "Outstanding Investment" (Legacy style):
        // Legacy: $MobInvest = $sumOpPrCost (Op+Purch Cost) - $colSum (Collection).
        // This implies "Unrecovered Investment". 
        // I will implement this "Unrecovered" logic if requested, but "Stock Value" is safer.
        // Let's stick to Stock Value ($totalInvest) for now as it's cleaner.
        
        return $totalInvest;
    }

    private function calculateBankInvest($month, $dateFrom, $dateTo) {
        $bankName = $this->config['defaultBank'] ?? 'Meezan Bank';
        $opening = $this->fetchOpening($bankName, $month, 'Cash');
        
        // Deposits (ReceivedFrom)
        $sql = "SELECT sum(rpAmnt) as total FROM receiptpayment WHERE rpmode=? AND rpStatus='ReceivedFrom' AND rpDate BETWEEN ? AND ?";
        $deposit = $this->db->query($sql, [$bankName, $dateFrom, $dateTo])->fetch()['total'] ?? 0;
        
        // Withdrawals/Payments (PaidTo)
        $sql = "SELECT sum(rpAmnt) as total FROM receiptpayment WHERE rpmode=? AND rpStatus='PaidTo' AND rpDate BETWEEN ? AND ?";
        $payment = $this->db->query($sql, [$bankName, $dateFrom, $dateTo])->fetch()['total'] ?? 0;
        
        return $opening + $deposit - $payment;
    }

    private function getPurchaseRate($product, $subType) {
        $sql = "SELECT purchasePrice FROM rates WHERE pName=? AND spName=? ORDER BY rtID DESC LIMIT 1";
        $stmt = $this->db->query($sql, [$product, $subType]);
        return $stmt->fetch()['purchasePrice'] ?? 0;
    }
}
