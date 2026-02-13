<?php
require_once __DIR__ . '/src/Services/AuthService.php';
use App\Services\AuthService;

$auth = new AuthService();
$auth->requireLogin();

// Legacy Code Support
// Many files expect $con (db connection) and $login_session variables.
include_once(__DIR__ . '/admin/includes/dbcon.php');

$user_check = $_SESSION['login_user'];
// We need to fetch the user row to support legacy $row = mysqli_fetch_assoc($ses_sql);
// Ideally legacy files should just use $_SESSION, but we can't be sure.
// Let's replicate the old query for compatibility.
$ses_sql = mysqli_query($con, "select * from users where username='$user_check'");
$row = mysqli_fetch_assoc($ses_sql);
$login_session = $row['username'] ?? null;

if(!isset($login_session)){
    header('Location: ../index.php'); // Legacy redirect
    exit();
}
?>