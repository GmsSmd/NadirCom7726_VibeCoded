<?php
namespace App\Services;

use App\Core\Database;

class PaymentService {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Get employees for Dues page (Active or Defaulter, showIn 2 or 3)
     */
    public function getDuesEmployees() {
        $sql = "SELECT EmpName FROM empinfo 
                WHERE (EmpStatus='Active' OR EmpStatus='Dfltr') 
                AND (showIn=2 OR showIn=3) 
                ORDER BY sort_order ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Add a payment (Paid to DO) or receipt (Received from DO)
     */
    public function addTransaction($type, $date, $status, $employee, $amount, $mode, $user, $notes) {
        $sql = "INSERT INTO receiptpayment (rpFor, rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [$type, $date, $status, $employee, $amount, $mode, $user, $notes];
        $this->db->query($sql, $params);
        return true;
    }

    /**
     * Get Daily Dues Summary for a given employee and date range
     */
    public function getDailyDues($employee, $dateFrom, $dateTo) {
        $summary = [];
        
        $start = is_numeric($dateFrom) ? $dateFrom : strtotime($dateFrom);
        $end = is_numeric($dateTo) ? $dateTo : strtotime($dateTo);

        // Loop through each day
        for ($i = $start; $i <= $end; $i += 86400) {
            $currentDate = date("Y-m-d", $i);
            
            // Get Paid Amount (PaidTo)
            $sqlPaid = "SELECT sum(rpAmnt) as total, rpNotes FROM receiptpayment 
                        WHERE rpFor='DO Dues' AND rpDate=? AND rpStatus='PaidTo' AND rpFromTo=?";
            $stmtPaid = $this->db->query($sqlPaid, [$currentDate, $employee]);
            $paidData = $stmtPaid->fetch();
            $paidAmount = $paidData['total'] ?? 0;
            $paidNotes = $paidData['rpNotes'] ?? '';

            // Get Received Amount (ReceivedFrom)
            $sqlRec = "SELECT sum(rpAmnt) as total, rpNotes FROM receiptpayment 
                       WHERE rpFor='DO Dues' AND rpDate=? AND rpStatus='ReceivedFrom' AND rpFromTo=?";
            $stmtRec = $this->db->query($sqlRec, [$currentDate, $employee]);
            $recData = $stmtRec->fetch();
            $recAmount = $recData['total'] ?? 0;
            $recNotes = $recData['rpNotes'] ?? '';

            $summary[] = [
                'date' => $currentDate,
                'paid' => $paidAmount,
                'paidNotes' => $paidNotes,
                'received' => $recAmount,
                'receivedNotes' => $recNotes
            ];
        }
        return $summary;
    }

    /**
     * Get Opening Balance for DO Dues
     */
    public function getDuesOpening($employee, $month) {
        $sql = "SELECT ocAmnt FROM openingclosing 
                WHERE oMonth=? AND ocType='DO Dues' AND ocEmp=?
                ORDER BY ocID DESC LIMIT 1";
        $stmt = $this->db->query($sql, [$month, $employee]);
        $result = $stmt->fetch();
        return $result['ocAmnt'] ?? 0;
    }
}
