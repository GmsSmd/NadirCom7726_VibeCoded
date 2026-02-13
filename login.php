<?php
    session_start();
    require_once __DIR__ . '/src/Services/AuthService.php';
    use App\Services\AuthService;

    $error='';
    if (isset($_POST['submit'])) 
    {
        // ... (rest of the POST handling)
        if (empty($_POST['username']) || empty($_POST['password'])) 
        {
            $error = "Please enter user name and password.";
        }
        else
        {
            $auth = new AuthService();
            if ($auth->login($_POST['username'], $_POST['password'])) {
                header("Location: admin/summary.php");
                exit();
            } else {
                $error = "Invalid UserName or Password.";
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        header("Location: index.php");
        exit();
    }
?>