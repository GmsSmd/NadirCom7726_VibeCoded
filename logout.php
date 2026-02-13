<?php
require_once __DIR__ . '/src/Services/AuthService.php';
use App\Services\AuthService;

$auth = new AuthService();
$auth->logout();
header("Location: ../index.php"); // Or index.php (it's in root?) logout is in root? 
// Current file is c:\xampp\htdocs\TempApps\NadirCom7726_VibeCoded\logout.php
header("Location: index.php");
?>