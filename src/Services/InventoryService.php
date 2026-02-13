<?php
namespace App\Services;

use App\Core\Database;

class InventoryService {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Get transactions for Otar and MFS
     */
    public function getTransactions($type, $filters) {
        $startDate = $filters['startDate'] ?? date('Y-m-01');
        $endDate = $filters['endDate'] ?? date('Y-m-t');
        $emp = $filters['employee'] ?? '---';

        if ($type === 'Otar') {
            $sql = "SELECT * FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadDate BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
            if ($emp !== '---') {
                $sql .= " AND loadEmp = ?";
                $params[] = $emp;
            }
            $sql .= " ORDER BY loadID ASC";
            return $this->db->query($sql, $params)->fetchAll();
        }

        if ($type === 'mfs') {
            $sql = "SELECT * FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsDate BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
            if ($emp !== '---') {
                $sql .= " AND mfsEmp = ?";
                $params[] = $emp;
            }
            $sql .= " ORDER BY mfsID ASC";
            return $this->db->query($sql, $params)->fetchAll();
        }
        return [];
    }

    /**
     * Get stock summary for Card, Mobile, SIM
     */
    public function getStockSummary($category, $startDate, $endDate) {
        $currentMonth = date('M-Y');
        
        // 1. Get Active Product Sub-types
        $sql = "SELECT typeName FROM types WHERE productName = ? AND isActive = 1";
        $subTypes = $this->db->query($sql, [$category])->fetchAll();
        
        $summary = [];
        foreach ($subTypes as $st) {
            $subType = $st['typeName'];
            
            // 2. Opening Stock
            $qOpen = "SELECT ocAmnt FROM openingclosing WHERE ocType = ? AND oMonth = ? AND ocEmp = ? ORDER BY ocID DESC LIMIT 1";
            $resOpen = $this->db->query($qOpen, [$category, $currentMonth, $subType])->fetch();
            $openingQty = (float)($resOpen['ocAmnt'] ?? 0);
            
            // 3. Purchase Price (Last Rate)
            $qRate = "SELECT purchasePrice FROM rates WHERE pName = ? AND spName = ? ORDER BY rtID DESC LIMIT 1";
            $resRate = $this->db->query($qRate, [$category, $subType])->fetch();
            $rate = (float)($resRate['purchasePrice'] ?? 0);
            
            // 4. Activity (Purchases & Sales)
            if ($category === 'Card') {
                // Cards use tbl_cards
                $qPurch = "SELECT sum(csQty) as total FROM tbl_cards WHERE csType = ? AND csStatus = 'Received' AND csDate BETWEEN ? AND ?";
                $resPurch = $this->db->query($qPurch, [$subType, $startDate, $endDate])->fetch();
                $purchaseQty = (float)($resPurch['total'] ?? 0);
                
                $qSale = "SELECT sum(csQty) as total_qty, avg(csRate) as avg_rate FROM tbl_cards WHERE csType = ? AND csStatus = 'Sent' AND csDate BETWEEN ? AND ?";
                $resSale = $this->db->query($qSale, [$subType, $startDate, $endDate])->fetch();
                $saleQty = (float)($resSale['total_qty'] ?? 0);
                $saleAvgRate = (float)($resSale['avg_rate'] ?? 0);
            } else {
                // Mobile and SIM use tbl_product_stock
                $qPurch = "SELECT sum(qty) as total FROM tbl_product_stock WHERE pName = ? AND pSubType = ? AND trtype = 'Received' AND sDate BETWEEN ? AND ?";
                $resPurch = $this->db->query($qPurch, [$category, $subType, $startDate, $endDate])->fetch();
                $purchaseQty = (float)($resPurch['total'] ?? 0);
                
                $qSale = "SELECT sum(qty) as total_qty, avg(rate) as avg_rate, sum(qty * rate) as total_amount FROM tbl_product_stock WHERE pName = ? AND pSubType = ? AND trtype = 'Sent' AND sDate BETWEEN ? AND ?";
                $resSale = $this->db->query($qSale, [$category, $subType, $startDate, $endDate])->fetch();
                $saleQty = (float)($resSale['total_qty'] ?? 0);
                $saleAvgRate = (float)($resSale['avg_rate'] ?? 0);
            }
            
            $closingQty = $openingQty + $purchaseQty - $saleQty;
            
            $summary[] = [
                'type' => $subType,
                'opening' => [
                    'qty' => $openingQty,
                    'rate' => $rate,
                    'amount' => $openingQty * $rate
                ],
                'purchase' => [
                    'qty' => $purchaseQty,
                    'rate' => $rate,
                    'amount' => $purchaseQty * $rate
                ],
                'sale' => [
                    'qty' => $saleQty,
                    'rate' => $saleAvgRate,
                    'amount' => $saleQty * $saleAvgRate
                ],
                'closing' => [
                    'qty' => $closingQty,
                    'amount' => $closingQty * $rate
                ]
            ];
        }
        
        return $summary;
    }

    /**
     * Get the external collection for a category
     */
    public function getCollection($category, $start, $end) {
        $sql = "SELECT sum(rpAmnt) as total FROM receiptpayment WHERE rpFor = ? AND rpStatus = 'ReceivedFrom' AND rpDate BETWEEN ? AND ?";
        $res = $this->db->query($sql, [$category, $start, $end])->fetch();
        return (float)($res['total'] ?? 0);
    }

    /**
     * Get detailed sales transactions for Card, Mobile, SIM
     */
    public function getDetailedSales($category, $startDate, $endDate, $emp = '---', $subType = '---') {
        if ($category === 'Card') {
            $sql = "SELECT * FROM tbl_cards WHERE csStatus='Sent' AND csDate BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
            if ($emp !== '---') { $sql .= " AND csEmp = ?"; $params[] = $emp; }
            if ($subType !== '---') { $sql .= " AND csType = ?"; $params[] = $subType; }
            $sql .= " ORDER BY csDate ASC";
        } else {
            $sql = "SELECT * FROM tbl_product_stock WHERE trtype='Sent' AND pName=? AND sDate BETWEEN ? AND ?";
            $params = [$category, $startDate, $endDate];
            if ($emp !== '---') { $sql .= " AND customer = ?"; $params[] = $emp; }
            if ($subType !== '---') { $sql .= " AND pSubType = ?"; $params[] = $subType; }
            $sql .= " ORDER BY sDate ASC";
        }
        
        $results = $this->db->query($sql, $params)->fetchAll();
        
        // Enrich with profit/loss if missing (for Mobile/SIM)
        foreach ($results as &$row) {
            if ($category !== 'Card') {
                $type = $row['pSubType'];
                $qRate = "SELECT purchasePrice FROM rates WHERE pName = ? AND spName = ? ORDER BY rtID DESC LIMIT 1";
                $resRate = $this->db->query($qRate, [$category, $type])->fetch();
                $pRate = (float)($resRate['purchasePrice'] ?? 0);
                
                $row['amount'] = $row['qty'] * $row['rate'];
                $row['cost'] = $row['qty'] * $pRate;
                $row['proLoss'] = $row['amount'] - $row['cost'];
            } else {
                $row['amount'] = $row['csTotalAmnt'];
                $row['proLoss'] = $row['csProLoss'];
            }
        }
        
        return $results;
    }
}
