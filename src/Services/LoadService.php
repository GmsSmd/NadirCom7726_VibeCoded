<?php
namespace App\Services;

use App\Core\Database;

class LoadService {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getLoadStats($employeeName, $date) {
        $sql = "SELECT 
                    SUM(loadAmnt) as total_load, 
                    SUM(loadTransfer) as total_transfer, 
                    SUM(loadProfit) as total_profit, 
                    SUM(loadExcessProfit) as total_excess_profit 
                FROM tbl_mobile_load 
                WHERE loadStatus = 'Sent' 
                AND loadEmp = ? 
                AND loadDate = ?";
        
        $stmt = $this->db->query($sql, [$employeeName, $date]);
        return $stmt->fetch();
    }
}
