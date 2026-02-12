<?php
include('includes/dbcon.php');
$qury = mysqli_query($con,"SELECT * FROM `config`") or die(mysqli_query());
$dat=mysqli_fetch_assoc($qury);

    var_dump($dat);
    
//$companyName=$dat['company'];
//$organizationName=$dat['organization'];
//$default_bank=$dat['defaultBank'];


//echo $companyName ."<br/>";
//echo $organizationName ."<br/>";
//echo $default_bank ."<br/>";
echo "End Message";
?>