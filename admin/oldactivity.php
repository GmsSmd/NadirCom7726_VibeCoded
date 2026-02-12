<?php
//include_once('../session.php');
include_once('includes/dbcon.php');
include_once('includes/globalvar.php');
include_once('includes/oldactivityfunctions.php');

//echo "<br><br><br>";

?>
<style>
	<?php
	include_once('styles/navbarstyle.php');
	include_once('styles/tablestyle.php');
	?>
</style>

<div style="border: solid black 0px;" align="center" class="doBar">
		<form  action="" method="POST">
				<table style="width:70%" cellpadding="0" cellspacing="0" border="0" class="table" id="headTable" >
					<tr>
						<td><a href='summary.php' id="LinkBtnEdit"><span>Summary</span></a></td>
						<td style="text-align: center;"> Date UpTo:
								<?php
								if (isset($_POST['getActivity']))
									$strDate1=$_POST['txtDateFrom'];
								else
									$strDate1= date('Y-m-d'); //$QueryFD date('Y-m-d');
								echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
								?>
								<input type="submit"  value="Show" name="getActivity" id="Btn">
						</td>
						<!--<td style="text-align: right;"> Date To:</td>
						<td style="text-align: left;">
							<?php
							if (isset($_POST['getActivity']))
								$strDate2=$_POST['txtDateTo'];
							else
								$strDate2= date('Y-m-d');
							echo "<input type=\"date\" value= \"$strDate2\"  name=\"txtDateTo\" id=\"tBox\">";
							?>
						</td>
						<td>
							<input type="submit"  value="Show" name="getActivity" id="Btn">
						</td>-->
					</tr>
				</table>
		</form>
</div>	
<div style="border: solid red 2px;" align="center" class="doBar">
<?php if(isset($_POST['txtDateFrom']))
	$dts="Activity Report From 1st To ".$_POST['txtDateFrom'];
else
	$dts="NO Date Selected";
?>


<div><h1><strong><?php echo $dts; ?> </strong></h1></div>
	<table style="width:100%" cellpadding="0" cellspacing="0" border="2" class="table" id="headTable" >
		
		<?php echo $strPL_Stock?>
	</table>	
	
	<table style="width:100%" cellpadding="0" cellspacing="0" border="2" class="table" id="headTable" >
		
		<tr>	
				<td style="text-align: center; width:25%"><h2>SALES</h2></td>
				<td style="text-align: center; width:25%"><h2>RECEIPTS</h2></td>
		</tr>
		<tr>
		<td> <?php echo $strSales; ?> </td>
		<td> <?php echo $strReceipts; ?> </td>
		</tr>
		<tr>	
				<td style="text-align: center; width:25%"> <h2>PURCHASES</h2></td>
				<td style="text-align: center; width:25%"> <h2>PAYMENTS</h2></td>
		</tr>
		<tr>
		<td> <?php echo $strPurchases; ?> </td>
		<td> <?php echo $strPayments; ?> </td>
		</tr>
	</table>
</div>