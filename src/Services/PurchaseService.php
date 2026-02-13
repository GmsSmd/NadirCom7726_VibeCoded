<?php
namespace App\Services;

use App\Core\Database;

class PurchaseService {
    private $db;
    private $config = [];

    public function __construct() {
        $this->db = Database::getInstance();
        $this->loadConfig();
    }

    private function loadConfig() {
        // Fetch necessary configs like in globalvar.php
        $keys = ['company', 'defaultBank'];
        foreach ($keys as $key) {
            $stmt = $this->db->query("SELECT customName FROM config WHERE name=?", [$key]);
            $res = $stmt->fetch();
            $this->config[$key] = $res['customName'] ?? '';
        }
    }

    private function getParentCompany() {
        return $this->config['company'] ?? 'Mye';
    }

    private function getDefaultBank() {
        return $this->config['defaultBank'] ?? 'Meezan Bank';
    }

    private function getPurchaseRates($product, $subType = null) {
        $sql = "SELECT purchasePrice, salePrice FROM rates WHERE pName=? " . ($subType ? "AND spName=?" : "") . " ORDER BY rtID DESC LIMIT 1";
        $params = $subType ? [$product, $subType] : [$product];
        $stmt = $this->db->query($sql, $params);
        return $stmt->fetch();
    }

    /**
     * Add Load Purchase
     */
    public function addLoad($date, $amount, $notes, $type, $user) {
        $parent = $this->getParentCompany();
        $rates = $this->getPurchaseRates('Otar');
        $pRate = $rates['purchasePrice'] ?? 0;
        $sRate = $rates['salePrice'] ?? 0;

        $sql = "INSERT INTO tbl_mobile_load (loadStatus, loadDate, loadEmp, loadAmnt, loadComments, pRate, sRate, purchaseType, User) 
                VALUES ('Received', ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [$date, $parent, $amount, $notes, $pRate, $sRate, $type, $user];
        $this->db->query($sql, $params);
        $loadId = $this->db->lastInsertId();

        if ($type === 'Cash') {
            $payAmount = $amount - ($amount * $pRate);
            $this->addBankPayment('Otar', $date, $parent, $payAmount, $user, $notes, $loadId);
        } elseif ($type === 'Debit MFS') {
             // Replicating legacy: 
             // 1. Mobile Load (Received, Debit MFS) - Already done above.
             // 2. ReceiptPayment (PaidTo Otar, from Bank!)
             // 3. tbl_financial_service (Sent)
             // 4. ReceiptPayment (ReceivedFrom MFS)
             
             $payAmount = $amount - ($amount * $pRate);
             
             // 2. Bank Payment (PaidTo Otar)
             $this->addBankPayment('Otar', $date, $parent, $payAmount, $user, 'Purchased From Financial Service', $loadId);

             // 3. MFS Sent
             $this->db->query("INSERT INTO tbl_financial_service (mfsStatus, mfsDate, mfsEmp, mfsAmnt, mfsComments, purchaseType, User) 
                               VALUES ('Sent', ?, ?, ?, ?, 'Debit MFS for load', ?)", 
                               [$date, $parent, $payAmount, 'Load Purchased From Financial Service', $user]);
             
             // 4. MFS Receipt (ReceivedFrom MFS)
             $this->addBankReceipt('MFS', $date, $parent, $payAmount, $user, 'Debited MFS for Load');
        }
        return true;
    }

    /**
     * Add MFS Purchase (Refill MFS)
     */
    public function addMfs($date, $amount, $notes, $type, $user) {
        $parent = $this->getParentCompany();
        
        $sql = "INSERT INTO tbl_financial_service (mfsStatus, mfsDate, mfsEmp, mfsAmnt, mfsComments, purchaseType, User) 
                VALUES ('Received', ?, ?, ?, ?, ?, ?)";
        $this->db->query($sql, [$date, $parent, $amount, $notes, $type, $user]);
        $id = $this->db->lastInsertId();

        if ($type === 'Cash') {
            $this->addBankPayment('MFS', $date, $parent, $amount, $user, $notes, $id);
        }
        return true;
    }
    
    /**
     * Debit MFS (Send MFS)
     */
    public function debitMfs($date, $amount, $notes, $user) {
        $parent = $this->getParentCompany();
        // 1. MFS Sent
        $sql = "INSERT INTO tbl_financial_service (mfsStatus, mfsDate, mfsEmp, mfsAmnt, mfsComments, purchaseType, User) 
                VALUES ('Sent', ?, ?, ?, ?, 'Debit MFS', ?)";
        $this->db->query($sql, [$date, $parent, $amount, $notes, $user]);
        
        // 2. Receipt (ReceivedFrom MFS into Bank)
        $this->addBankReceipt('MFS', $date, $parent, $amount, $user, $notes);
        return true;
    }

    /**
     * Add Cards Purchase
     */
    public function addCards($date, $subType, $qty, $notes, $type, $user) {
        $parent = $this->getParentCompany();
        $rates = $this->getPurchaseRates('Card', $subType);
        $pRate = $rates['purchasePrice'] ?? 0;
        
        if ($pRate == 0) return false; // Error: Rate not set

        $orgAmount = $qty * $pRate;

        $sql = "INSERT INTO tbl_cards (csStatus, csDate, csEmp, csType, csQty, csOrgAmnt, csRate, csComments, User, purchaseType) 
                VALUES ('Received', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->db->query($sql, [$date, $parent, $subType, $qty, $orgAmount, $pRate, $notes, $user, $type]);
        $id = $this->db->lastInsertId();
        
        if ($type === 'Cash') {
            $this->addBankPayment('Card', $date, $parent, $orgAmount, $user, $notes, $id);
        }
        return true;
    }

    /**
     * Add Phones/SIMs Purchase (tbl_product_stock)
     */
    public function addProductStock($productName, $date, $subType, $qty, $notes, $type, $user) {
        $parent = $this->getParentCompany();
        $rates = $this->getPurchaseRates($productName, $subType);
        $pRate = $rates['purchasePrice'] ?? 0;

        if ($pRate == 0) return false; // Error

        $sql = "INSERT INTO tbl_product_stock (sDate, pName, pSubType, trtype, customer, qty, rate, sComments, User, purchaseType) 
                VALUES (?, ?, ?, 'Received', ?, ?, ?, ?, ?, ?)";
        $this->db->query($sql, [$date, $productName, $subType, $parent, $qty, $pRate, $notes, $user, $type]);
        $id = $this->db->lastInsertId();

        if ($type === 'Cash') {
            $payAmount = $qty * $pRate;
            $this->addBankPayment($productName, $date, $parent, $payAmount, $user, $notes, $id);
        }
        return true;
    }

    // Helpers
    private function addBankPayment($for, $date, $to, $amount, $user, $notes, $linkedKey = null) {
        $mode = $this->getDefaultBank();
        $sql = "INSERT INTO receiptpayment (rpFor, rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes, rpStatus2, linkedKey) 
                VALUES (?, ?, 'PaidTo', ?, ?, ?, ?, ?, 'Cash', ?)";
        $this->db->query($sql, [$for, $date, $to, $amount, $mode, $user, $notes, $linkedKey]);
    }

    private function addBankReceipt($for, $date, $from, $amount, $user, $notes) {
        $mode = $this->getDefaultBank();
        $sql = "INSERT INTO receiptpayment (rpFor, rpDate, rpStatus, rpFromTo, rpAmnt, rpmode, rpUser, rpNotes) 
                VALUES (?, ?, 'ReceivedFrom', ?, ?, ?, ?, ?)";
        $this->db->query($sql, [$for, $date, $from, $amount, $mode, $user, $notes]);
    }

    // Data Fetching for UI
    public function getDailyLoad($date) {
        return $this->db->query("SELECT * FROM tbl_mobile_load WHERE loadDate=? AND loadEmp=?", [$date, $this->getParentCompany()])->fetchAll();
    }
    public function getDailyMfsReceived($date) {
        return $this->db->query("SELECT * FROM tbl_financial_service WHERE mfsStatus='Received' AND mfsDate=? AND mfsEmp=?", [$date, $this->getParentCompany()])->fetchAll();
    }
    public function getDailyCards($date) {
        return $this->db->query("SELECT * FROM tbl_cards WHERE csDate=? AND csEmp=?", [$date, $this->getParentCompany()])->fetchAll();
    }
    public function getDailyProduct($date, $pName) {
        return $this->db->query("SELECT * FROM tbl_product_stock WHERE sDate=? AND pName=? AND customer=? AND trtype='Received'", [$date, $pName, $this->getParentCompany()])->fetchAll();
    }
     public function getDailyMfsSent($date) {
        return $this->db->query("SELECT * FROM tbl_financial_service WHERE mfsStatus='Sent' AND mfsDate=? AND mfsEmp=?", [$date, $this->getParentCompany()])->fetchAll();
    }

    public function getSubTypes($productName) {
        return $this->db->query("SELECT typeName FROM types WHERE productName=? AND isActive=1", [$productName])->fetchAll();
    }
}
