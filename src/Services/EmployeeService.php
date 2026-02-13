<?php
namespace App\Services;

use App\Core\Database;

class EmployeeService {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllEmployees($status = 'Active') {
        $sql = "SELECT * FROM empinfo WHERE EmpStatus = ? ORDER BY EmpName ASC";
        $stmt = $this->db->query($sql, [$status]);
        return $stmt->fetchAll();
    }

    public function getEmployeeById($id) {
        $sql = "SELECT * FROM empinfo WHERE EmpID = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }

    /**
     * Aggregates salary data for the current month (projections)
     */
    public function getSalaryGrid($startDate, $endDate) {
        $employees = $this->getAllEmployees();
        $grid = [];

        foreach ($employees as $emp) {
            $name = $emp['EmpName'];
            $basic = (float)$emp['EmpFixedSalary'];
            $otarComRate = (float)($emp['otcomrate'] ?? 0.001);

            if ($basic <= 0) continue;

            $coms = [];
            
            // 1. Otar Commission
            $q1 = $this->db->query("SELECT sum(loadAmnt) as total FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadEmp=? AND loadDate BETWEEN ? AND ?", [$name, $startDate, $endDate]);
            $coms['otar'] = round((float)($q1->fetch()['total'] ?? 0) * $otarComRate, 0);

            // Mapping for other commissions
            $comTypes = [
                'mfs' => 'mfs Comission',
                'market' => 'Market SIM Comission',
                'activity' => 'Activity SIM Comission',
                'device' => 'Device+Handset Comission',
                'postpaid' => 'PostPaid Comission',
                'other' => 'Other Comission'
            ];

            foreach ($comTypes as $key => $dbType) {
                $q = $this->db->query("SELECT sum(comAmnt) as total FROM comission WHERE rp='Paid' AND comType=? AND comEmp=? AND comDate BETWEEN ? AND ?", [$dbType, $name, $startDate, $endDate]);
                $coms[$key] = (float)($q->fetch()['total'] ?? 0);
            }

            $gross = $basic + array_sum($coms);

            $grid[] = [
                'name' => $name,
                'basic' => $basic,
                'coms' => $coms,
                'gross' => $gross
            ];
        }
        return $grid;
    }

    /**
     * Fetches saved salary records for a specific month
     */
    public function getSalaryRecords($month) {
        $sql = "SELECT * FROM salary WHERE salMonth = ?";
        $stmt = $this->db->query($sql, [$month]);
        return $stmt->fetchAll();
    }

    /**
     * Fetches pending due expenses
     */
    public function getPendingExpenses() {
        $sql = "SELECT * FROM dueexp WHERE status = 'Pending'";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
