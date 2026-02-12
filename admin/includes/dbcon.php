<?php
require_once __DIR__ . '/../../config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
/*
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
*/

//$mobLoadName="Otar";
//$fs_name="JazzCash";
//$scratchCardName="Card";
//$mobileDevicesName="Device";
//$sims_name="SIMs";

$load_table="tbl_mobile_load";
$fs_table="tbl_financial_service";
$card_table="tbl_cards";
$sims_devices_table="tbl_product_stock";
//echo "<br/><br/><br/>";
?>