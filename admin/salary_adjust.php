<?php
echo "<br><br><br>";
include_once('includes/variables.php');
if(isset($_POST['updateSalary'])){
	$forSalMonth=$_POST['cMonthSelect'];
	$oldSum=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(activitySimCom) AS comSum FROM salary WHERE salMonth='$forSalMonth' AND status='Pending';"));
	$oldSum=$oldSum['comSum'];
	
	$newSum=0;
	$comisionSum=0;
	$newCutting=0;
	foreach($_POST['comID'] as $k=>$v){
		$qq=mysqli_query($con,"UPDATE salary SET activitySimCom='$v', grossSal=grossSal+'$v', netSal=netSal+'$v'  WHERE id='$k';");
		$newSum=$newSum+$v;
		$comisionSum=$comisionSum+$v;
	}
	
	foreach($_POST['cutID'] as $k=>$v){
		$qq=mysqli_query($con,"UPDATE salary SET cutting='$v', netSal=netSal-'$v'  WHERE id='$k';");
		$newCutting=$newCutting-$v;
		
	}
	
	
	if($oldSum < $comisionSum){
		$oldDueSalary=mysqli_fetch_assoc(mysqli_query($con,"SELECT ocAmnt FROM openingclosing WHERE cMonth='$forSalMonth' AND ocEmp='DueSalary';"));
		$oldDueSalary= $oldDueSalary['ocAmnt'];
		$NewDueSalary=-1*((-1*$oldDueSalary)+$comisionSum+$newCutting);
		
		$oldDueProfit=mysqli_fetch_assoc(mysqli_query($con,"SELECT ocAmnt FROM openingclosing WHERE cMonth='$forSalMonth' AND ocEmp='DueProfit';"));
		$oldDueProfit=$oldDueProfit['ocAmnt'];
		$NewDueProfit=$oldDueProfit+$comisionSum-$newCutting;
		
		mysqli_query($con,"UPDATE openingclosing SET ocAmnt='$NewDueSalary', checking='$oldDueSalary' WHERE cMonth='$forSalMonth' AND ocEmp='DueSalary';");
		mysqli_query($con,"UPDATE openingclosing SET ocAmnt='$NewDueProfit', checking='$oldDueProfit' WHERE cMonth='$forSalMonth' AND ocEmp='DueProfit';");
	}
	//foreach($_POST['comID'] as $k=>$v){
	//	echo $k . " --> " .$v. "<br>";
	//}
	//echo "<pre>";
	//print_r($_POST);
	//echo "</pre>";
}
?>
	<head>
		<title>Salary Adjustment</title>
			<style>
				<?php
				include_once('styles/navbarstyle.php');
				include_once('styles/tablestyle.php');
				include_once('includes/navbar.php');
				?>
			</style>
	</head>
	<br/>
	<br/>
	<center>
		<caption> <h1>Salary Adjustment</h1></caption>
	</center>
	<hr/>
	<form name="f1" action="" method="POST">
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
			<tr>
				<th rowspan="2">ID</th>
				<th rowspan="2">Month</th>
				<th rowspan="2">Employee</th>
				<th rowspan="2">Basic Salary</th>
				<th colspan="7" style="text-align: Center;" > <h2> Comission</h2> </th>
				<th rowspan="2">Gross Salary</th>
				<th rowspan="2">Advance</th>
				<th rowspan="2">Cutting</th>
				<th rowspan="2">Net Sal</th>
				<th rowspan="2">Status</th>
				<th rowspan="2">Action</th>
			</tr>
			<tr>
				<th>Otar</th>
				<th>MFS</th>
				<th>Market SIM</th>
				<th>Activity SIM</th>
				<th>Dev+Set</th>
				<th>PostPaid</th>
				<th>Other</th>
			</tr>
			<?php
			$sumBasic=0; $sumOtar=0; $sumMfs=0; $sumOther=0; $sumGrossSal=0;
			$forMonth=strftime( '%b-%Y', strtotime( '-1 month', $date ));
			$doQ=mysqli_query($con,"SELECT * from salary WHERE salMonth='$forMonth' AND status='Pending';");
			while($data=mysqli_fetch_array($doQ)){	
				$EmployeeId=$data['id'];
				$Employee=$data['empName'];
				$EmployeeCom=$data['activitySimCom'];
				$EmpCutting=$data['cutting'];
				
				echo "<tr>";			
					echo "<td>";
					echo $data['id'];
					echo "</td>";
					
					echo "<td>";
					echo $data['salMonth'];
					echo "</td>";
					
					echo "<td>";
					echo $data['empName'];
					echo "</td>";
					
					echo "<td>";
					echo $data['bSal'];
					echo "</td>";
					
					echo "<td>";
					echo $data['otarCom'];
					echo "</td>";
					
					echo "<td>";
					echo $data['mfsCom'];
					echo "</td>";
					
					echo "<td>";
					echo $data['marketSimCom'];
					echo "</td>";
					
					echo "<td>";
					if($EmployeeCom){
						echo "<input type='number' name=comID[$EmployeeId] value='$EmployeeCom' id='tBoxSpecial' disabled></input>";
					}else{
						echo "<input type='number' name=comID[$EmployeeId] value='$EmployeeCom' id='tBoxSpecial'></input>";
					}
					echo "</td>";
					
					echo "<td>";
					echo $data['deviceHandsetCom'];
					echo "</td>";
					
					echo "<td>";
					echo $data['postpaidCom'];
					echo "</td>";
					
					echo "<td>";
					echo $data['otherCom'];
					echo "</td>";
					
					echo "<td>";
					echo $data['grossSal'];
					echo "</td>";
					
					echo "<td>";
					echo $data['advance'];
					echo "</td>";
					
					echo "<td>";
					if($EmpCutting){
						echo "<input type='number' name=cutID[$EmployeeId] value='$EmpCutting' id='tBoxSpecial' disabled></input>";
					}else{
						echo "<input type='number' name=cutID[$EmployeeId] value='$EmpCutting' id='tBoxSpecial'></input>";
					}
					echo "</td>";
					
					echo "<td>";
					echo $data['netSal'];
					echo "</td>";
					
					echo "<td>";
					echo $data['status'];
					echo "</td>";
					
					echo "<td>";
					echo $data['rcptNo'];
					echo "</td>";
				echo "</tr>";
			}
				?>

				<tfoot>
					<tr>
						<td style="text-align: center;" colspan="17">Salary Month
							<select name="cMonthSelect" id="sBox">
								<?php
									$year  = date('Y');
									$month = date('m');
									$date = mktime( 0, 0, 0, $month, 1, $year );
									echo "<option selected>". strftime( '%b-%Y', strtotime( '-1 month', $date ) ) ."</option>";
								?>
							</select>	
							<input type="submit" name="updateSalary" id="Btn" >
						</td>
					</tr>
				</tfoot>
		</table>
	</form>
	
</div>
<?php
/*echo "<br><br><br>";
include_once('includes/variables.php');
if(isset($_POST['updateSalary'])){
	$forSalMonth=$_POST['cMonthSelect'];
	$oldSum=mysqli_fetch_assoc(mysqli_query($con,"SELECT sum(activitySimCom) AS comSum FROM salary WHERE salMonth='$forSalMonth' AND status='Pending';"));
	$oldSum=$oldSum['comSum'];
	
	$newSum=0;
	foreach($_POST['salId'] as $k=>$v){
		$qq=mysqli_query($con,"UPDATE salary SET activitySimCom='$v', grossSal=grossSal+'$v', netSal=netSal+'$v'  WHERE id='$k';");
		$newSum=$newSum+$v;
	}
	
	
	if($oldSum < $newSum){
		$oldDueSalary=mysqli_fetch_assoc(mysqli_query($con,"SELECT ocAmnt FROM openingclosing WHERE cMonth='$forSalMonth' AND ocEmp='DueSalary';"));
		$oldDueSalary= $oldDueSalary['ocAmnt'];
		$NewDueSalary=-1*((-1*$oldDueSalary)+$newSum);
		
		$oldDueProfit=mysqli_fetch_assoc(mysqli_query($con,"SELECT ocAmnt FROM openingclosing WHERE cMonth='$forSalMonth' AND ocEmp='DueProfit';"));
		$oldDueProfit=$oldDueProfit['ocAmnt'];
		$NewDueProfit=$oldDueProfit+$newSum;
		
		mysqli_query($con,"UPDATE openingclosing SET ocAmnt='$NewDueSalary', checking='$oldDueSalary' WHERE cMonth='$forSalMonth' AND ocEmp='DueSalary';");
		mysqli_query($con,"UPDATE openingclosing SET ocAmnt='$NewDueProfit', checking='$oldDueProfit' WHERE cMonth='$forSalMonth' AND ocEmp='DueProfit';");
	}
	//foreach($_POST['salId'] as $k=>$v){
	//	echo $k . " --> " .$v. "<br>";
	//}
	//echo "<pre>";
	//print_r($_POST);
	//echo "</pre>";
}
?>
	<head>
		<title>Salary Adjustment</title>
			<style>
				<?php
				include_once('styles/navbarstyle.php');
				include_once('styles/tablestyle.php');
				include_once('includes/navbar.php');
				?>
			</style>
	</head>
	<br/>
	<br/>
	<center>
		<caption> <h1>Salary Adjustment</h1></caption>
	</center>
	<hr/>
	<form name="f1" action="" method="POST">
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
			<tr>
				<th rowspan="2">ID</th>
				<th rowspan="2">Month</th>
				<th rowspan="2">Employee</th>
				<th rowspan="2">Basic Salary</th>
				<th colspan="7" style="text-align: Center;" > <h2> Comission</h2> </th>
				<th rowspan="2">Gross Salary</th>
				<th rowspan="2">Advance</th>
				<th rowspan="2">Cutting</th>
				<th rowspan="2">Net Sal</th>
				<th rowspan="2">Status</th>
				<th rowspan="2">Action</th>
			</tr>
			<tr>
				<th>Otar</th>
				<th>MFS</th>
				<th>Market SIM</th>
				<th>Activity SIM</th>
				<th>Dev+Set</th>
				<th>PostPaid</th>
				<th>Other</th>
			</tr>
			<?php
			$sumBasic=0; $sumOtar=0; $sumMfs=0; $sumOther=0; $sumGrossSal=0;
			$forMonth=strftime( '%b-%Y', strtotime( '-1 month', $date ));
			$doQ=mysqli_query($con,"SELECT * from salary WHERE salMonth='$forMonth' AND status='Pending';");
			while($data=mysqli_fetch_array($doQ)){	
				$EmployeeId=$data['id'];
				$Employee=$data['empName'];
				$EmployeeCom=$data['activitySimCom'];
				
				echo "<tr>";			
					echo "<td>";
					echo $data['id'];
					echo "</td>";
					
					echo "<td>";
					echo $data['salMonth'];
					echo "</td>";
					
					echo "<td>";
					echo $data['empName'];
					echo "</td>";
					
					echo "<td>";
					echo $data['bSal'];
					echo "</td>";
					
					echo "<td>";
					echo $data['otarCom'];
					echo "</td>";
					
					echo "<td>";
					echo $data['mfsCom'];
					echo "</td>";
					
					echo "<td>";
					echo $data['marketSimCom'];
					echo "</td>";
					
					echo "<td>";
					if($EmployeeCom){
						echo "<input type='number' name=salId[$EmployeeId] value='$EmployeeCom' id='tBoxSpecial' disabled></input>";
					}else{
						echo "<input type='number' name=salId[$EmployeeId] value='$EmployeeCom' id='tBoxSpecial'></input>";
					}
					
					echo "</td>";
					
					echo "<td>";
					echo $data['deviceHandsetCom'];
					echo "</td>";
					
					echo "<td>";
					echo $data['postpaidCom'];
					echo "</td>";
					
					echo "<td>";
					echo $data['otherCom'];
					echo "</td>";
					
					echo "<td>";
					echo $data['grossSal'];
					echo "</td>";
					
					echo "<td>";
					echo $data['advance'];
					echo "</td>";
					
					echo "<td>";
					echo $data['cutting'];
					echo "</td>";
					
					echo "<td>";
					echo $data['netSal'];
					echo "</td>";
					
					echo "<td>";
					echo $data['status'];
					echo "</td>";
					
					echo "<td>";
					echo $data['rcptNo'];
					echo "</td>";
				echo "</tr>";
			}
				?>

				<tfoot>
					<tr>
						<td style="text-align: center;" colspan="17">Salary Month
							<select name="cMonthSelect" id="sBox">
								<?php
									$year  = date('Y');
									$month = date('m');
									$date = mktime( 0, 0, 0, $month, 1, $year );
									echo "<option selected>". strftime( '%b-%Y', strtotime( '-1 month', $date ) ) ."</option>";
								?>
							</select>	
							<input type="submit" name="updateSalary" id="Btn" >
						</td>
					</tr>
				</tfoot>
		</table>
	</form>
	
</div>
*/?>
