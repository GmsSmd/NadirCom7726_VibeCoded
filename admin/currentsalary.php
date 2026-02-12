<?php
include_once('../session.php');
include_once('includes/variables.php');
//include_once('includes/openclose.php');
include_once('includes/globalvar.php');

$closing=0;

?>
			<head>
				<title>Current Salary</title>
					<style>
						<?php
						
						include_once('styles/navbarstyle.php');
						include_once('styles/tablestyle.php');
						include_once('includes/navbar.php');
						?>
					</style>
			</head>
				<center>
					<caption> <h1>This Month Salary</h1></caption>
				</center>
	<div>
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
				<tr ><td colspan="12"><center><h2> Salaries </h2></center></td></tr>
				<tr >
					<th rowspan="2">Employee</th>
					<th rowspan="2">Basic Salary</th>
					<th colspan="7">Comissions</th>
					
					<th rowspan="2">Gross Salary</th>
					<th rowspan="2">Deduction</th>
					<th rowspan="2">Net Salary</th>
				</tr>
				<tr>
					<th>Otar</th>
					<th>MFS</th>
					<th>Market SIM</th>
					<th>Activity SIM</th>
					<th>Device+Handset</th>
					<th>PostPaid</th>
					<th>Other Comission</th>
					
				</tr>
				<?php
				$sumBasic=0; $sumOtar=0; $sumMfs=0; $sumOther=0; $sumGrossSal=0; $sumActivity=0; $sumDevSet=0; $sumMarket=0; $sumPostPaid=0; $sumDeductions=0; $sumNetSalary=0;
				
				$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' Order by sort_order ASC");
				while($data=mysqli_fetch_array($doQ))
				{	
				
							$Employee=$data['EmpName'];
							
							$bSal=mysqli_query($con,"SELECT EmpFixedsalary, otcomrate From empinfo WHERE EmpName='$Employee' ");
							$Data0=mysqli_fetch_array($bSal);
							$basicSal = $Data0['EmpFixedsalary'];
							$otarComissionRateEmp=$Data0['otcomrate'];
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
									$otarComission=round(($load*$otarComissionRateEmp),0);
							echo "<td>";
							echo $otarComission;
							echo "</td>";
							
									$q2=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='mfs Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2=mysqli_fetch_array($q2);
									$MFSComission=$Data2['sum(comAmnt)'];
							echo "<td>";
							echo $MFSComission;
							echo "</td>";
									$q2222=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='Market SIM Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2222=mysqli_fetch_array($q2222);
									$marketSimComission=$Data2222['sum(comAmnt)'];
							echo "<td>";
							echo $marketSimComission;
							echo "</td>";
									$q2333=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='Activity SIM Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2333=mysqli_fetch_array($q2333);
									$activitySimComission=$Data2333['sum(comAmnt)'];
							echo "<td>";
							echo $activitySimComission;
							echo "</td>";
									$q2444=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='Device+Handset Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2444=mysqli_fetch_array($q2444);
									$deviceHandsetComission=$Data2444['sum(comAmnt)'];
							echo "<td>";
							echo $deviceHandsetComission;
							echo "</td>";
									$q2555=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='PostPaid Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data2555=mysqli_fetch_array($q2555);
									$postPaidComission=$Data2555['sum(comAmnt)'];
							echo "<td>";
							echo $postPaidComission;
							echo "</td>";
									$q3=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='Paid' AND comType='Other Comission' AND comEmp='$Employee' AND comDate BETWEEN '$QueryFD' AND '$QueryLD' ");
									$Data3=mysqli_fetch_array($q3);
									$otherComission=$Data3['sum(comAmnt)'];
							echo "<td>";
							echo $otherComission;
							echo "</td>";
							
									$grossSal=$basicSal+$otarComission+$MFSComission+$marketSimComission+$activitySimComission+$deviceHandsetComission+$postPaidComission+$otherComission;
							echo "<td>";
							echo $grossSal;
							echo "</td>";
							
							        $q45=mysqli_query($con,"SELECT sum(comAmnt) FROM comission WHERE rp='$CurrentMonth' AND comType='Salary Deduction' AND comEmp='$Employee'");
									$Data45=mysqli_fetch_array($q45);
									$deduction=$Data45['sum(comAmnt)'];
							
							echo "<td>";
							echo $deduction;
							echo "</td>";
							
							        $netSalary=$grossSal-$deduction;
							
							echo "<td>";
							echo $netSalary;
							echo "</td>";
							
						echo "</tr>";
					$sumBasic=$sumBasic+ $basicSal;
					$sumOtar=$sumOtar+$otarComission;
					$sumMfs=$sumMfs+$MFSComission;
					$sumMarket=$sumMarket+$marketSimComission;
					$sumActivity=$sumActivity+$activitySimComission;
					$sumDevSet=$sumDevSet+$deviceHandsetComission;
					$sumPostPaid=$sumPostPaid+$postPaidComission;
					$sumOther=$sumOther+$otherComission;
					$sumGrossSal=$sumGrossSal+$grossSal;
					$sumDeductions=$sumDeductions+$deduction;
					$sumNetSalary=$sumNetSalary+$netSalary;
					}
				}
				?>

				<tfoot >
					<tr style="border: solid black 2px;"  >
						<td colspan="1" style="text-align: right;"> <b> TOTAL AMOUNT: </b></td>
						<td> <b><?php echo $sumBasic; ?></b></td>
						<td> <b><?php echo $sumOtar; ?></b></td>
						<td> <b><?php echo $sumMfs; ?></b></td>
						<td> <b><?php echo $sumMarket; ?></b></td>
						<td> <b><?php echo $sumActivity; ?></b></td>
						<td> <b><?php echo $sumDevSet; ?></b></td>
						<td> <b><?php echo $sumPostPaid; ?></b></td>
						<td> <b><?php echo $sumOther; ?></b></td>
						<td> <b><?php echo $sumGrossSal; ?></b></td>
						<td> <b><?php echo $sumDeductions; ?></b></td>
						<td> <b><?php echo $sumNetSalary; ?></b></td>
					</tr>
				</tfoot>

		</table>
		
	</div>