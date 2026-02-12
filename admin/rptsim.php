<?php
include_once('../session.php');
include_once('includes/variables.php');
include_once('includes/openclose.php');
include_once('includes/globalvar.php');
$closing=0;
if (isset($_POST['getsimDue']))
	{
		$StartDate=$_POST['txtDateFrom'];
		$QueryLD=$StartDate;
		$dateFirst=date('Y-m-01', strtotime($StartDate));
		$QueryFD=$dateFirst;
		$selectedMonth=date('M-Y', strtotime($StartDate));
        $CurrentMonth=$selectedMonth;
    }
?>
	<head>
		<title>SIM Receivables</title>
			<style>
				<?php
				
				include_once('styles/navbarstyle.php');
				include_once('styles/tablestyle.php');
				include_once('includes/navbar.php');
				?>
			</style>
	</head>
	<center>
		<caption> <h1>Opening & Closing</h1></caption>
	</center>
	<form  action="" method="POST">
		<table cellpadding="0" cellspacing="0" border="1" align="center" id="dbResult">
			<tr >
				<td colspan="5" > 
					<center><h2> Receivables Against SIM</h2></center>
				</td>
			</tr>
			<tr>
				<td colspan="5" style="text-align: center;"> Date UpTo:
					<?php
					if (isset($_POST['getsimDue']))
						$strDate1=$_POST['txtDateFrom'];
					else
						$strDate1= date('Y-m-d'); //$QueryFD date('Y-m-d');
					echo "<input type=\"date\" value= \"$strDate1\"  name=\"txtDateFrom\" id=\"tBox\" >";
					?>
					<input type="submit"  value="Show" name="getsimDue" id="Btn">
				</td>
			</tr>
			<tr >
				<th rowspan="1">Name</th>
				<th colspan="1">Opening</th>
				<th colspan="1">Sending</th>
				<th colspan="1">Receiving</th>
				<th colspan="1">Closing</th>
			</tr>
    	<?php
    		/*-----<<<<<<<<<<<<<      do Receivables MODULE      >>>>>>>>>>>>-----*/
    				$sumOpenCash=0;
    				$sumOpenCard=0;
    				$sumOpenMobile=0;
    				$sumOpenSIM=0;
    				$sumOpenDue=0;
    				$sumLoad=0;
    				$sumClose=0;
    				$sumAmnt=0;
    				$mobSum=0;
    				$simSum=0;
    				$sumGivendo=0;
    				$sumLMCTaken=0;
    				$sumCardTaken=0;
    				$sumMblTaken=0;
    				$sumTakenSIM=0;
    				$sumTakendo=0;
    				$sumCashClose=0;
    				$sumCardClose=0;
    				$sumMblClose=0;
    				$sumSIMclose=0;
    				$sumDueClose=0;
		$doQ=mysqli_query($con,"SELECT EmpName from empinfo WHERE EmpStatus='Active' Order by sort_order ASC");
			while($data00=mysqli_fetch_array($doQ))
				{	
		            // OPENING MODULE start
            		{	
        			    $Employee=$data00['EmpName'];
        			 	$SIMCashOpening=mysqli_query($con,"SELECT ocAmnt From openingclosing WHERE ocEmp='$Employee' AND oMonth='$CurrentMonth' AND ocType='SIM'  ");
        				$Data03=mysqli_fetch_array($SIMCashOpening);
        				$openSIMCash = $Data03['ocAmnt'];
            		}
            		// OPENING MODULE End
            		
            		
            		// RECEIVABLE MODULE start
            		{
						$sAmntSum1=0;
						$sq8 = mysqli_query($con,"SELECT typeName FROM types WHERE productName='SIM'")or die(mysqli_query());
						WHILE($Data8=mysqli_fetch_array($sq8))
						{
							$subType=$Data8['typeName'];
							$slAmnt=0; $qt2=0; $rt2=0; $sumQt=0;
							$q9 = mysqli_query($con,"SELECT * from tbl_product_stock WHERE pSubType='$subType' AND trtype='Sent' AND customer='$Employee' AND sDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
							WHILE($d9=mysqli_fetch_array($q9))
							{
								$qt2=$d9['qty'];
								$rt2=$d9['rate'];
								$sumQt=$sumQt+$qt2;
								$slAmnt=$slAmnt+($qt2*$rt2);
							}
							$sAmntSum1=$sAmntSum1+$slAmnt;
						}
                    }
            		// RECEIVABLE MODULE End
            		
            		
            
            		// RECEIVED MODULE Start
            		{
						$q13=mysqli_query($con,"SELECT sum(rpAmnt) FROM receiptpayment WHERE rpFor ='SIM' AND rpStatus='ReceivedFrom' AND rpFromTo='$Employee' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD' ");
						$Data13=mysqli_fetch_array($q13);
                        $takenSIM= $Data13['sum(rpAmnt)'];
            		}
            		// RECEIVED MODULE End			
            			
            
            		// CLOSING MODULE start
            		{
            		    $SIMClose=($openSIMCash+$sAmntSum1) - $takenSIM;
            		        if($SIMClose!=0)
                    			{	
                    				echo "<tr>";
                    					echo "<td>";
                    					echo $Employee;
                    					echo "</td>";
                    					
                    					echo "<td>";
                    					echo $openSIMCash;
                    					echo "</td>";
                    					
                    					echo "<td>";
                    					echo $sAmntSum1;
                    					echo "</td>";
                    					
                    					echo "<td>";
                    					echo $takenSIM;
                    					echo "</td>";
                    					
                    					echo "<td>";
                    					echo $SIMClose;
                    					echo "</td>";
                    				echo "</tr>";
                    		    }
            					// Footer Sums
            							$sumOpenSIM=$sumOpenSIM+$openSIMCash;
            							$simSum=$simSum+$sAmntSum1;
            							$sumTakenSIM=$sumTakenSIM+$takenSIM;
            							$sumSIMclose=$sumSIMclose+$SIMClose;
            		}
				}
				?>
				<tfoot >
					<tr style="border: solid black 2px;"  >
						<td rowspan="1" style="text-align: right;"> <b> TOTAL: </b></td>
						<td> <b><?php //echo $sumOpenSIM; ?></b></td>
						<td> <b><?php //echo $simSum; ?></b></td>
						<td> <b><?php //echo $sumTakenSIM; ?></b></td>
						<td> <b><?php echo $sumSIMclose; ?></b></td>
					</tr>
				</tfoot>
		</table>
	</form>
	</div>