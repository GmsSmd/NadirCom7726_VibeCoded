<?php
namespace App\Services;

use App\Core\Database;

class SalesService {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Get initial opening balance for a specific employee, month, and type.
     */
    public function getOpeningBalance($employee, $month, $type) {
        $sql = "SELECT sum(ocAmnt) as total_amount 
                FROM openingclosing 
                WHERE ocEmp = ? AND oMonth = ? AND ocType = ?";
        $stmt = $this->db->query($sql, [$employee, $month, $type]);
        $result = $stmt->fetch();
        return $result['total_amount'] ?? 0;
    }

    /**
     * Get MFS stats for a specific date and employee.
     */
    public function getMfsStats($employee, $date) {
        $stats = [
            'sent' => 0,
            'received' => 0,
            'close' => 0
        ];

        // Sent
        $sql = "SELECT sum(mfsAmnt) as total 
                FROM tbl_financial_service 
                WHERE mfsStatus='Sent' AND mfsEmp=? AND mfsDate=?";
        $stmt = $this->db->query($sql, [$employee, $date]);
        $stats['sent'] = $stmt->fetch()['total'] ?? 0;

        // Received
        $sql = "SELECT sum(mfsAmnt) as total 
                FROM tbl_financial_service 
                WHERE mfsStatus='Received' AND mfsEmp=? AND mfsDate=?";
        $stmt = $this->db->query($sql, [$employee, $date]);
        $stats['received'] = $stmt->fetch()['total'] ?? 0;

        $stats['close'] = $stats['sent'] - $stats['received'];

        return $stats;
    }

    /**
     * Get Card stats for a specific date and employee.
     */
    public function getCardStats($employee, $date) {
        $sql = "SELECT 
                    sum(csQty) as qty, 
                    sum(csOrgAmnt) as org_amount, 
                    sum(csTotalAmnt) as total_amount, 
                    avg(csRate) as avg_rate, 
                    sum(csProLoss) as profit_loss 
                FROM tbl_cards 
                WHERE csStatus='Sent' AND csEmp=? AND csDate=?";
        $stmt = $this->db->query($sql, [$employee, $date]);
        return $stmt->fetch();
    }

    /**
     * Get Received Payments for a specific date, employee, and type.
     */
    public function getReceivedPayments($employee, $date, $type) {
        $sql = "SELECT sum(rpAmnt) as total 
                FROM receiptpayment 
                WHERE rpStatus='ReceivedFrom' AND rpFromTo=? AND rpDate=? AND rpFor=?";
        $stmt = $this->db->query($sql, [$employee, $date, $type]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Get Received Payments for a date range (for Mobile/SIM closing calculation).
     */
    public function getReceivedPaymentsRange($employee, $dateFrom, $dateTo, $type) {
        $sql = "SELECT sum(rpAmnt) as total 
                FROM receiptpayment 
                WHERE rpFor =? AND rpStatus='ReceivedFrom' AND rpFromTo=? AND rpDate BETWEEN ? AND ?";
        $stmt = $this->db->query($sql, [$type, $employee, $dateFrom, $dateTo]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
    
     /**
     * Calculate Sales Amount Sum for Product Types (Mobile, SIM, Card)
     * Mirrors the logic of looping through types and stock in dosales.php
     */
    public function getProductSalesSum($employee, $dateFrom, $dateTo, $productName) {
        $totalSalesAmount = 0;
        
        // 1. Get subtypes
        $sqlTypes = "SELECT typeName FROM types WHERE productName = ?";
        $stmtTypes = $this->db->query($sqlTypes, [$productName]);
        $types = $stmtTypes->fetchAll();

        foreach ($types as $typeRow) {
            $subType = $typeRow['typeName'];
            
            // 2. Get stock sent
            $sqlStock = "SELECT qty, rate 
                         FROM tbl_product_stock 
                         WHERE pSubType = ? 
                         AND trtype = 'Sent' 
                         AND customer = ? 
                         AND sDate BETWEEN ? AND ?";
            
            $stmtStock = $this->db->query($sqlStock, [$subType, $employee, $dateFrom, $dateTo]);
            $stocks = $stmtStock->fetchAll();

            foreach ($stocks as $stock) {
                $totalSalesAmount += ($stock['qty'] * $stock['rate']);
            }
        }
        
        return $totalSalesAmount;
    }

    /**
     * Calculate Profit/Loss for Mobile/SIM
     * Mirrors getPl function in dosales.php
     */
    public function getProductProfitLoss($employee, $productName, $dateFrom, $dateTo) {
        $plSum = 0;

        $sql = "SELECT * FROM tbl_product_stock 
                WHERE trtype='Sent' AND customer=? AND pName=? AND sDate BETWEEN ? AND ? 
                ORDER BY sDate ASC";
        $stmt = $this->db->query($sql, [$employee, $productName, $dateFrom, $dateTo]);
        $stocks = $stmt->fetchAll();

        foreach ($stocks as $stock) {
            $type = $stock['pSubType'];
            $qty = $stock['qty'];
            $rate = $stock['rate'];
            $amount = $qty * $rate;

            // Get purchase rate
            // Note: This logic seems brittle in the original code (Limit 1 desc), but preserving for now.
            $sqlRate = "SELECT purchasePrice FROM rates WHERE pName=? AND spName=? ORDER BY rtID DESC LIMIT 1";
            $stmtRate = $this->db->query($sqlRate, [$productName, $type]);
            $rateData = $stmtRate->fetch();
            $purchaseRate = $rateData['purchasePrice'] ?? 0;

            $cost = $qty * $purchaseRate;
            $pl = $amount - $cost;
            $plSum += $pl;
        }

        return $plSum;
    }
    
    /**
     * Get all active DOs (Data Operators/Sales People)
     */
     public function getActiveEmployees() {
         $sql = "SELECT EmpName, doLine FROM empinfo WHERE EmpStatus='Active' AND (showIn=1 OR showIn=3) ORDER BY sort_order ASC";
         $stmt = $this->db->query($sql);
         return $stmt->fetchAll();
     }
}
