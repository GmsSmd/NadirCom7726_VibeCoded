<?php
namespace App\Services;

use App\Core\Database;

class AuthService {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login($username, $password) {
        $username = stripslashes($username);
        $password = stripslashes($password);
        
        // Legacy: Plain text password check
        // Ideally we should use password_verify, but for now we match legacy.
        $sql = "SELECT * FROM users WHERE username=? AND password=?";
        $stmt = $this->db->query($sql, [$username, $password]);
        $user = $stmt->fetch();

        if ($user) {
            // Login Success
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user['username'];
            $_SESSION['login_type'] = $user['user_type'];
            
            // Load Config into Session (Legacy requirement)
            $this->loadSystemConfig();
            
            return true;
        }

        return false;
    }

    private function loadSystemConfig() {
        $keys = ['company', 'organization', 'defaultbank'];
        foreach ($keys as $key) {
            $stmt = $this->db->query("SELECT customName FROM config WHERE name=?", [$key]);
            $res = $stmt->fetch();
            if ($res) {
                $sessionKey = ($key === 'defaultbank') ? 'default_bank' : ($key . '_name');
                $_SESSION[$sessionKey] = $res['customName'];
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    public function isAuthenticated() {
        return isset($_SESSION['login_user']);
    }

    public function getCurrentUser() {
        return $_SESSION['login_user'] ?? null;
    }

    public function requireLogin() {
        if (!$this->isAuthenticated()) {
            header("Location: ../login.php");
            exit();
        }
    }
}
