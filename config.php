<?php
// Database Credentials
require_once __DIR__ . '/src/autoload.php';
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'nadircom7726');

// App Settings
define('APP_ENV', 'development'); // production or development
define('DEBUG_MODE', true);

// Error Reporting
if (defined('APP_ENV') && APP_ENV === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}
?>
