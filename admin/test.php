<?php
include_once('includes/variables.php');
include_once('includes/globalvar.php');

echo "OK<br><br><br>";



if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
else
{
    echo "Connected";
}

?>