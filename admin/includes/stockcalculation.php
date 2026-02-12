													<?php 
													$opQtySum=0;
													$opAmntSum=0;
													$pQtySum=0;
													$pAmntSum=0;
													$sQtySum=0;
													$sAmntSum=0;
													$cQtySum=0;
													$cAmntSum=0;
													$colSum=0;
																										
													$sql = mysqli_query($con,"SELECT typeName FROM types WHERE productName='Card' AND isActive=1")or die(mysqli_query());
													WHILE($Data=mysqli_fetch_array($sql))
														
													
														{
															$subType=$Data['typeName'];
																	$q = mysqli_query($con,"SELECT * from openingclosing WHERE ocType= 'Card' AND oMonth='$CurrentMonth' AND ocEmp='$subType' ORDER BY ocID DESC LIMIT 1 ")or die(mysqli_query());	
																		$d=mysqli_fetch_array($q);
																	$open=$d['ocAmnt'];
																	$q = mysqli_query($con,"SELECT purchasePrice from rates WHERE pName= 'Card' AND spName='$subType' ORDER BY rtID DESC LIMIT 1 ")or die(mysqli_query());	
																		$r=mysqli_fetch_array($q);
																		$rt1=$r['purchasePrice'];
																		$opAmnt=$open * $rt1;
																	$q = mysqli_query($con,"SELECT sum(csQty) from tbl_cards WHERE csType='$subType' AND csStatus='Received' AND csDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
																		$d=mysqli_fetch_array($q);
																	$purchz=$d['sum(csQty)'];
																		$prAmnt=$purchz*$rt1;
																		
																		$slAmnt=0;
																		$qt2=0;
																		$rt2=0;
																		$sumrt=0;
																		$cnt=0;
																		$avgrt=0;
																		$q = mysqli_query($con," SELECT sum(csQty), avg(csRate) from tbl_cards WHERE csType='$subType' AND csStatus='Sent' AND csDate BETWEEN '$QueryFD' AND '$QueryLD' ")or die(mysqli_query());	
																		WHILE($d=mysqli_fetch_array($q))
																			{
																			$qt2=$qt2+$d['sum(csQty)'];
																			$rt2=$d['avg(csRate)'];
																			$sumrt=$sumrt+$rt2;
																			$cnt=$cnt+1;
																			}
																		if($cnt>0)
																			$avgrt=$sumrt/$cnt;
																			$slAmnt=$qt2*$avgrt;
																	$cl=$open + $purchz - $qt2;
																	$clAmnt=$cl*$rt1;
														$opQtySum=$opQtySum + $open;
														$opAmntSum=$opAmntSum + $opAmnt;
														$pQtySum=$pQtySum + $purchz;
														$pAmntSum=$pAmntSum + $prAmnt;
														$sQtySum=$sQtySum + $qt2;
														$sAmntSum=$sAmntSum + $slAmnt;
														$cQtySum=$cQtySum + $cl;
														$cAmntSum=$cAmntSum + $clAmnt;
														}
													$q = mysqli_query($con,"SELECT sum(rpAmnt) from receiptpayment WHERE rpFor='Card' AND rpStatus='ReceivedFrom' AND rpDate BETWEEN '$QueryFD' AND '$QueryLD'  ")or die(mysqli_query());	
													$d=mysqli_fetch_array($q);
													$colSum=$d['sum(rpAmnt)'];
													?>