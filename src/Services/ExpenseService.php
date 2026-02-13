<?php
namespace App\Services;

use App\Core\Database;

class ExpenseService {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Add a regular expense and record it in the financial ledger
     */
    public function addExpense(string $date, string $description, float $amount, string $user, string $bank) {
        if ($amount <= 0 || empty($description)) {
            return false;
        }

        try {
            $this->db->beginTransaction();

            // 1. Insert into regularexp
            $sqlExp = "INSERT INTO regularexp (expDate, type, description, amnt, savedby) VALUES (?, 'Expense', ?, ?, ?)";
            $this->db->query($sqlExp, [$date, $description, $amount, $user]);

            // 2. Insert into receiptpayment
            $sqlRp = "INSERT INTO receiptpayment (rpDate, rpFor, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes) VALUES (?, 'Expense', 'PaidTo', 'Expense', ?, ?, ?, ?)";
            $this->db->query($sqlRp, [$date, $amount, $bank, $user, $description]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * Get regular expenses for a given period
     */
    public function getExpenses(string $startDate, string $endDate) {
        $sql = "SELECT * FROM regularexp WHERE type='expense' AND expDate BETWEEN ? AND ? ORDER BY expDate DESC, id DESC";
        return $this->db->query($sql, [$startDate, $endDate])->fetchAll();
    }

    /**
     * Manage Petty Cash (Add/Subtract) and synchronize with financial ledger
     */
    public function managePettyCash(string $date, string $type, string $mode, float $amount, string $comments, string $user) {
        if ($amount <= 0) return false;

        try {
            $this->db->beginTransaction();

            if ($type === 'AddIntopetty') {
                // Shifted from Bank/Cash to Petty Cash
                $sqlPetty = "INSERT INTO petty (date, status, fromTo, type, amnt, comments) VALUES (?, 'Add', ?, 'petty', ?, ?)";
                $this->db->query($sqlPetty, [$date, $mode, $amount, $comments]);

                $sqlRp = "INSERT INTO receiptpayment (rpFor, rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes) VALUES ('Withdraw', ?, 'PaidTo', 'Petty', ?, ?, ?, 'Shifted to Petty Cash')";
                $this->db->query($sqlRp, [$date, $amount, $mode, $user]);
            } else {
                // Received back from Petty Cash or Spent from Petty
                $sqlPetty = "INSERT INTO petty (date, status, fromTo, type, amnt, comments) VALUES (?, 'Sub', ?, 'petty', ?, ?)";
                $this->db->query($sqlPetty, [$date, $mode, $amount, $comments]);

                $sqlRp = "INSERT INTO receiptpayment (rpFor, rpDate, rpStatus, rpAmnt, rpmode, rpUser, rpNotes) VALUES ('petty', ?, 'ReceivedFrom', ?, ?, ?, 'Received From Petty Cash')";
                $this->db->query($sqlRp, [$date, $amount, $mode, $user]);
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * Get Petty Cash history for a given period
     */
    public function getPettyHistory(string $startDate, string $endDate) {
        $sql = "SELECT * FROM petty WHERE date BETWEEN ? AND ? ORDER BY date DESC, id DESC";
        return $this->db->query($sql, [$startDate, $endDate])->fetchAll();
    }

    /**
     * Get Petty Cash opening balance for a specific month
     */
    public function getPettyOpeningBalance(string $month) {
        $sql = "SELECT ocAmnt FROM openingclosing WHERE ocType='Petty Cash' AND oMonth = ?";
        $res = $this->db->query($sql, [$month])->fetch();
        return (float)($res['ocAmnt'] ?? 0);
    }
}
