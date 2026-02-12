<?php
include_once('../includes/dbcon.php');
//include_once('../../session.php');
include_once('../includes/variables.php');
include_once('../includes/globalvar.php');
$eid = $_GET['ID'];
$edit = mysqli_query($con,"SELECT * FROM retailers WHERE ID = '$eid'") or die(mysqli_error());
$emp = mysqli_fetch_array($edit);

//org_name, ml_number, do_name, do_line_number, DO, retailer_shop_name, name, number

    $orgName=$emp['org_name'];
	$orgNum=$emp['ml_number'];
	$doName=$emp['do_name'];
	$doNum=$emp['do_line_number'];
	$retailerName=$emp['retailer_shop_name'];
	$retailerNumber=$emp['number'];;


if (isset($_POST['Update']))
	{
		$orgName=$_POST['txtOrgName'];
		$orgNum=$_POST['txtOrgNumber'];
		$doName=$_POST['doNameSelect'];
		$doNum=$_POST['doLineNum'];
		$retailerName=$_POST['txtRetailerName'];
		$retailerNumber=$_POST['txtRetailerNumber'];
		
		
	    if($orgName=='')
			echo '<script type="text/javascript">alert("Please Enter Organization Name.");</script>';
		else if($orgNum=='')
			echo '<script type="text/javascript">alert("Please Enter Master Line Number.");</script>';
		else if($retailerName=='')
			echo '<script type="text/javascript">alert("Please Enter Retailer Name.");</script>';
		else if($retailerNumber=='')
			echo '<script type="text/javascript">alert("Please Enter Retailer Number.");</script>';
		else if($doName=='---')
			echo '<script type="text/javascript">alert("Please Select DO Name from list.");</script>';
		else if($doNum=='')
			echo '<script type="text/javascript">alert("Please Enter DO Line Number.");</script>';
		else
		{
		/*echo '<script type="text/javascript">alert("'.$eid.'");</script>';
		echo '<script type="text/javascript">alert("'.$orgName.'");</script>';
		echo '<script type="text/javascript">alert("'.$orgNum.'");</script>';
		echo '<script type="text/javascript">alert("'.$retailerName.'");</script>';
		echo '<script type="text/javascript">alert("'.$retailerNumber.'");</script>';
		echo '<script type="text/javascript">alert("'.$doName.'");</script>';
		echo '<script type="text/javascript">alert("'.$doNum.'");</script>';
		*/
		
		//$sq = mysqli_query($con,"UPDATE retailers SET number='$number' ,name='$nm' ,  do='$do' WHERE ID='$eid' ")or die(mysqli_query());
    	$sq = mysqli_query($con,"UPDATE retailers SET org_name='$orgName', ml_number='$orgNum', do_name='$doName', do_line_number='$doNum', DO='$doName', retailer_shop_name='$retailerName', name='$retailerName', number='$retailerNumber' WHERE ID='$eid'; ")or die(mysqli_query());
		//echo '<script type="text/javascript">alert("'.$sq.'");</script>';
		echo '<script type="text/javascript">alert("Successfully updated")</script>';
		}
	header("Location:../addrt.php");
	}
	

if (isset($_POST['Cancel']))
	header("Location: ../addrt.php");
	
?>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<title>Edit Retailer</title>
			<style>
			<?php
			include_once('../styles/navbarstyle.php');
			include_once('../styles/tablestyle.php');
			?>
			</style>
	</head>
			
		<?php
			include_once('../includes/navbar.php');
		?>

	<div class="container" align="center">
						<center> <caption> <h2>Edit Retailer</h2></caption> </center>
						
				<div  style="border: solid black 0px; ">
						
							<form name="f1" action="" method="POST">
									<table cellpadding="0" cellspacing="0" border="1" class="table" id="HeadTable" >
												<tr>
													<td style="text-align: right;" >Organization:</td>
													<td style="text-align: left;" > 
													    <input type="text" name="txtOrgName" id="iBox" Value="<?php echo $orgName; ?>">
													</td>
													<td style="text-align: right;" >Master Line #:</td>
													<td style="text-align: left;" > 
													    <input type="text" name="txtOrgNumber" id="iBox" Value="<?php echo $orgNum; ?>">
													</td>
												</tr>
												
												
												<tr>
													<td style="text-align: right;"> DO Name: </td>
													
													<td style="text-align: left;" >
															<select name="doNameSelect" id="sBox">
																	<option >---</option>
																	<?php
																		$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' AND empType='DO' ");
																		while($data=mysqli_fetch_array($doQ))
																			{
																				
																				if($data['EmpName']==$doName)
																				{
																				    echo "<option selected>";
																				    echo $data['EmpName'];
																				}
																				else
																				{
																				    echo "<option>";
																				    echo $data['EmpName'];
																				}
																				   echo "</option>"; 
																				
																			}
																	?>
															</select>
													</td>
													<td style="text-align: right;" >DO Line #:</td>
													<td style="text-align: left;" > 
													    <input type="text" name="doLineNum" id="iBox" Value="<?php echo $doNum; ?>">
													</td>
												</tr>
												
												
												<tr>
													<td style="text-align: right;" >
														Retailer Name:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtRetailerName" id="iBox" Value="<?php echo $retailerName; ?>">
													</td>
													
														<td style="text-align: right;" > 
														Retailer Number:
													</td>
													<td style="text-align: left;" >
													<input type="text" name="txtRetailerNumber" id="iBox" Value="<?php echo $retailerNumber; ?>">
													</td>
													
												</tr>
												<tr>
													<td>
													</td>
													<td colspan="1" style="text-align: left;" > 
														<input type="submit"  value="Update" name="Update" id="Btn"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
														<input type="submit"  value="Cancel" name="Cancel" id="Btn">
													</td>
												</tr>
									</table>
							</form>
				</div>
			
	</div>
</html>
