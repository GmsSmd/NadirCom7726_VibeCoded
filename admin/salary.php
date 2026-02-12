<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/openclose.php');
include_once('includes/globalvar.php');
$closing=0;

?>
			<head>
				<title>salary</title>
					<style>
						<?php
						
						include_once('styles/navbarstyle.php');
						include_once('styles/tablestyle.php');
						include_once('includes/navbar.php');
						?>
					</style>
			</head>
				<center>
					<caption> <h1>Salary Details</h1></caption>
				</center>
			<form name="f1" action="" method="POST">
				<table cellpadding="0" cellspacing="0" border="0" class="table" id="HeadTable" >
					<tr>
						<td style="text-align: right;">Closing Month</td>
						<td style="text-align: left;" >
							<select name="cMonthSelect" id="sBox">
								<?php
									$year  = date('Y');
									$month = date('m');
									$date = mktime( 0, 0, 0, $month, 1, $year );
									echo "<option>". strftime( '%b-%Y', strtotime( '-2 month', $date ) ) ."</option>";
									echo "<option>". strftime( '%b-%Y', strtotime( '-1 month', $date ) ) ."</option>";
									echo "<option selected>". strftime( '%b-%Y', strtotime( '+0 month', $date ) ) ."</option>";
									echo "<option>". strftime( '%b-%Y', strtotime( '+1 month', $date ) ) ."</option>";
									echo "<option>". strftime( '%b-%Y', strtotime( '+2 month', $date ) ) ."</option>";
								?>
							</select>	
						</td>
						<td style="text-align: right;">Opening Month</td>
						<td style="text-align: left;" >
							<select name="oMonthSelect" id="sBox">
								<?php	
									$year  = date('Y');
									$month = date('m');
									$date = mktime( 0, 0, 0, $month, 1, $year );
									echo "<option>". strftime( '%b-%Y', strtotime( '-2 month', $date ) ) ."</option>";
									echo "<option>". strftime( '%b-%Y', strtotime( '-1 month', $date ) ) ."</option>";
									echo "<option>". strftime( '%b-%Y', strtotime( '+0 month', $date ) ) ."</option>";
									echo "<option selected>". strftime( '%b-%Y', strtotime( '+1 month', $date ) ) ."</option>";
									echo "<option>". strftime( '%b-%Y', strtotime( '+2 month', $date ) ) ."</option>";
								?>
							</select>	
						</td>
					<td>
						<input type="submit"  value="Save" name="SaveClosing" id="Btn" >
					</td>
					</tr>
				</table>
			</form>
				
		<br><br>
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
				
				<tr >
					<th>Employee</th>
					<th>Basic salary</th>
					<th>Otar Comission</th>
					<th>MFS Comission</th>
					<th>Other Comission</th>
					<th>Total salary</th>
					<th>Acton</th>
				</tr>
				<?php
				$sumBasic=0; $sumOtar=0; $sumMfs=0; $sumOther=0; $sumGrossSal=0;
				
			$doQ=mysqli_query($con,"SELECT EmpName from empinfo ");
			while($data=mysqli_fetch_array($doQ))
				{	
				
							$Employee=$data['EmpName'];
							
							$bSal=mysqli_query($con,"SELECT EmpFixedsalary From empinfo WHERE EmpName='$Employee' ");
							$Data0=mysqli_fetch_array($bSal);
							$basicSal = $Data0['EmpFixedsalary'];
				if($basicSal>0)
					{
						echo "<tr>";			
							echo "<td>";
							echo $Employee;
							echo "</td>";
									
							echo "<td>";
							echo $basicSal;
							echo "</td>";
									$q1=mysqli_query($con,"SELECT sum(loadAmnt) FROM tbl_mobile_load WHERE loadStatus='Sent' AND loadEmp='$Employee' AND loadDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data1=mysqli_fetch_array($q1);
									$load= $Data1['sum(loadAmnt)'];
									$otarComission=$load*$otarComissionEmp;
							echo "<td>";
							echo $otarComission;
							echo "</td>";
							
									$q2=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='mfs Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2=mysqli_fetch_array($q2);
									$MFSComission=$Data2['sum(comAmnt)'];
							echo "<td>";
							echo $MFSComission;
							echo "</td>";
									$q3=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='Other Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data3=mysqli_fetch_array($q3);
									$otherComission=$Data3['sum(comAmnt)'];
							echo "<td>";
							echo $otherComission;
							echo "</td>";
							
									$grossSal=$basicSal+$otarComission+$MFSComission+$otherComission;
							echo "<td>";
							echo $grossSal;
							echo "</td>";
							
						echo "</tr>";
					$sumBasic=$sumBasic+ $basicSal;
					$sumOtar=$sumOtar+$otarComission;
					$sumMfs=$sumMfs+$MFSComission;
					$sumOther=$sumOther+$otherComission;
					$sumGrossSal=$sumGrossSal+$grossSal;
					
					}
				}
				?>

				<tfoot >
					<tr style="border: solid black 2px;"  >
						<td colspan="1" style="text-align: right;"> <b> TOTAL AMOUNT: </b></td>
						<td> <b><?php echo $sumBasic; ?></b></td>
						<td> <b><?php echo $sumOtar; ?></b></td>
						<td> <b><?php echo $sumMfs; ?></b></td>
						<td> <b><?php echo $sumOther; ?></b></td>
						<td> <b><?php echo $sumGrossSal; ?></b></td>
					</tr>
				</tfoot>

		</table>
	</div>