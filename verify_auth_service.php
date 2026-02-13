<?php
require_once __DIR__ . '/config.php';
use App\Services\AuthService;

// Ensure session is started before any output if needed, or just let AuthService handle it before output.
try {
    $service = new AuthService();
    echo "AuthService initialized successfully.\n";

    // Test Login with REAL credentials found in DB
    echo "Testing Login with 'admin' / 'admin@123'...\n";
    $login = $service->login('admin', 'admin@123');
    echo "Login Result: " . ($login ? "Success" : "Failed") . "\n";

    // Test Config Loading (Check if session vars set)
    if (isset($_SESSION['company_name'])) {
        echo "Config Loaded: " . $_SESSION['company_name'] . "\n";
    }

    // Test Logout
    echo "Testing Logout...\n";
    $service->logout();
    echo "Session Status: " . (session_status() === PHP_SESSION_NONE ? "Destroyed" : "Active (or partial)") . "\n";


} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
