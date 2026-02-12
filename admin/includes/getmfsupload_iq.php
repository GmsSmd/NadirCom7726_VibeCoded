<?
include_once('../../session.php');
include_once('variables.php');
include_once('globalvar.php');
if(isset($_POST["Import"]))
	{
	    //ini_set('max_execution_time', '300');
		$skipCount=isset($_POST["skpEntries"])? $_POST["skpEntries"] : 0;
		
		if ($_FILES["file"]["error"] > 0)
			{
				echo "Error: " . $_FILES["file"]["error"] . "<br>";
			}
		//echo $filename=$_FILES["file"]["tmp_name"];
		$filename=$_FILES["file"]["tmp_name"];
		if($_FILES["file"]["size"] > 0)
		{
			$counter=1;
		  	$file = fopen($filename, "r");
	        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
	        {
				$initiator_user_name=trim($emapData[0]," ");
				$initiator_msisdn=trim($emapData[1]," ");
				$initiator_organization=trim($emapData[2]," ");
				$initiator_city=trim($emapData[3]," ");
				$tx_id=trim($emapData[4]," ");
				//echo "<br/>";
				//echo $tx_id;
			//	echo "closing msg";
				//exit;
				
				$tx_type=trim($emapData[5]," ");
				$tx_date=trim($emapData[6]," ");
				$tx_time=trim($emapData[7]," ");
				$tx_status=trim($emapData[8]," ");
				$balance_before_tx=trim($emapData[9]," ");
				$tx_amount=trim($emapData[10]," ");
				$balance_after_tx=trim($emapData[11]," ");
				$tx_effect="";
				$tx_channel=trim($emapData[12]," ");
				$fee=trim($emapData[13]," ");
				$fed=trim($emapData[14]," ");
				$beneficiary_msisdn=trim($emapData[15]," ");
				$beneficiary_name=trim($emapData[16]," ");
				$operator_msisdn=trim($emapData[17]," ");
				$operator_name=trim($emapData[18]," ");
				$customer_msisdn=trim($emapData[19]," ");
				$customer_name=trim($emapData[20]," ");
				$failed_reason=trim($emapData[21]," ");
				$current_commission=trim($emapData[22]," ");
				$current_wht=trim($emapData[23]," ");
				$pos_id=trim($emapData[24]," ");
				$third_party_tid=trim($emapData[25]," ");
				$merchant_name=trim($emapData[26]," ");
				$reversal_id=trim($emapData[27]," ");
				$comment=trim($emapData[28]," ");
				
				$addstatus="Pending";
				$recorddate="Not Recorded";
				$uploadedby=trim($currentActiveUser," ");
				
				//1if($initiator_organization===$orgnization_name)
				//1{
					$qur=mysqli_query($con,"SELECT ref_id FROM tbl_initiator_query WHERE tx_id='$tx_id';")or die(mysqli_query());
					$dat=mysqli_fetch_array($qur);
					if(! $dat )
					{
						if($counter > $skipCount)
						{
						    
						    if($initiator_organization==$orgnization_name)
						    {
						        if($tx_type=='Transfer(B2B)')
						        {
						            
        							    if($balance_before_tx > $balance_after_tx and $initiator_organization==$orgnization_name)
                							$tx_effect="Sent";
                						else if($balance_before_tx > $balance_after_tx)
                						    $tx_effect="Received";
                						else if ($balance_before_tx < $balance_after_tx)
                							$tx_effect="Sent";
                						else
                							$tx_effect="No Info";
        							    
        							    $doName="";
        							    $qury00=mysqli_query($con,"SELECT count(*) FROM retailers WHERE retailer_shop_name='$beneficiary_name';")or die(mysqli_query());
        							    $data00=mysqli_fetch_array($qury00);
        								
        								if($data00['count(*)'] == 1)
            							    {
                							
        							            $qury=mysqli_query($con,"SELECT * FROM retailers WHERE retailer_shop_name='$beneficiary_name';")or die(mysqli_query());
        								        $data2=mysqli_fetch_array($qury);
        								        $doName=$data2['do_name'];
            							    }
        							    else
        							        {
        							            
        							           /* $qury11=mysqli_query($con,"SELECT * FROM empinfo WHERE completeName='$operator_name';")or die(mysqli_query());
        								        $data11=mysqli_fetch_array($qury11);
        								        $doName=$data11['EmpName'];
        							            */
        							            
                							
        							            /*$qury=mysqli_query($con,"SELECT * FROM retailers WHERE retailer_shop_name='$beneficiary_name';")or die(mysqli_query());
        								        $data2=mysqli_fetch_array($qury);
        								        $doName=$data2['do_name'];*/
            							    }
        							    
        							    
        							    
        							    /*
        							    $qury=mysqli_query($con,"SELECT * FROM retailers WHERE retailer_shop_name='$beneficiary_name';")or die(mysqli_query());
        								$data2=mysqli_fetch_array($qury);
        								$doName=$data2['do_name'];
        								*/
        								
        								$qry = mysqli_query($con,"INSERT INTO tbl_initiator_query 
        								(initiator_user_name, initiator_msisdn, initiator_organization, initiator_city, tx_id, tx_type, tx_date, tx_time, tx_status, balance_before_tx, tx_amount, balance_after_tx, tx_effect, tx_channel, fee, fed, beneficiary_name, operator_msisdn, operator_name, customer_msisdn, customer_name, failed_reason, current_commission, current_wht, pos_id, third_party_tid, merchant_name, reversal_id, comment, do_name, addstatus, recorddate, uploadedby) VALUES 
        								('$initiator_user_name', '$initiator_msisdn', '$initiator_organization', '$initiator_city', '$tx_id', '$tx_type', '$tx_date', '$tx_time', '$tx_status', '$balance_before_tx', '$tx_amount', '$balance_after_tx','$tx_effect', '$tx_channel', '$fee', '$fed', '$beneficiary_name', '$operator_msisdn', '$operator_name', '$customer_msisdn', '$customer_name', '$failed_reason', '$current_commission', '$current_wht', '$pos_id', '$third_party_tid', '$merchant_name', '$reversal_id', '$comment', '$doName', '$addstatus', '$recorddate', '$uploadedby');
        								")or die(mysqli_query());
						        }
						        
						        
						        if($tx_type=='Cash in' OR $tx_type=='Cash out' OR $tx_type=='Collecting' OR $tx_type=='Indigo Bills (Postpaid payment)' OR $tx_type=='Remitting' OR $tx_type=='Utility Bills Payment' OR $tx_type=='IBFT Outgoing OTC')
        							{
                						if($balance_before_tx > $balance_after_tx)
                						    $tx_effect="Sent";
                						else if ($balance_before_tx < $balance_after_tx)
                							$tx_effect="Received";
                						else
                							$tx_effect="No Info";
                						
                						/*
                						$doName="";	
                						$qury00=mysqli_query($con,"SELECT count(*) FROM retailers WHERE number='$initiator_user_name2';")or die(mysqli_query());
        							    $data00=mysqli_fetch_array($qury00);
        								
        								if($data00['count(*)'] == 1)
            							    {
                							}*/
        							            $qury=mysqli_query($con,"SELECT * FROM retailers WHERE number='$initiator_msisdn';")or die(mysqli_query());
                								$data2=mysqli_fetch_array($qury);
        								        $doName=$data2['do_name'];
            							    
        								
        								$qry = mysqli_query($con,"INSERT INTO tbl_initiator_query 
        								(initiator_user_name, initiator_msisdn, initiator_organization, initiator_city, tx_id, tx_type, tx_date, tx_time, tx_status, balance_before_tx, tx_amount, balance_after_tx, tx_effect, tx_channel, fee, fed, beneficiary_name, operator_msisdn, operator_name, customer_msisdn, customer_name, failed_reason, current_commission, current_wht, pos_id, third_party_tid, merchant_name, reversal_id, comment, do_name, addstatus, recorddate, uploadedby) VALUES 
        								('$initiator_user_name', '$initiator_msisdn', '$initiator_organization', '$initiator_city', '$tx_id', '$tx_type', '$tx_date', '$tx_time', '$tx_status', '$balance_before_tx', '$tx_amount', '$balance_after_tx','$tx_effect', '$tx_channel', '$fee', '$fed', '$beneficiary_name', '$operator_msisdn', '$operator_name', '$customer_msisdn', '$customer_name', '$failed_reason', '$current_commission', '$current_wht', '$pos_id', '$third_party_tid', '$merchant_name', '$reversal_id', '$comment', '$doName', '$addstatus', '$recorddate', '$uploadedby');
        								")or die(mysqli_query());
        							}
						            
						  }
						  else
						  {
						        if($tx_type=='Transfer(B2B)')
						        {
        							    if($balance_before_tx > $balance_after_tx and $initiator_organization==$orgnization_name)
                							$tx_effect="Sent";
                						else if($balance_before_tx > $balance_after_tx)
                						    $tx_effect="Received";
                						else if ($balance_before_tx < $balance_after_tx)
                							$tx_effect="Sent";
                						else
                							$tx_effect="No Info";
                							
                							
                						$initiator_user_name2 = ltrim($initiator_user_name, "0");
                						$initiator_user_name2= "92".$initiator_user_name2;
                							
        							    /*
        							    $doName="";
        							    $qury00=mysqli_query($con,"SELECT count(*) FROM retailers WHERE number='$initiator_user_name2';")or die(mysqli_query());
        							    $data00=mysqli_fetch_array($qury00);
        								
        								if($data00['count(*)'] == 1)
            							    {
            							     }   */
                							    $qury=mysqli_query($con,"SELECT * FROM retailers WHERE number='$initiator_user_name2';")or die(mysqli_query());
                							    $data2=mysqli_fetch_array($qury);
                								$doName=$data2['do_name'];
            							    
        								
        								$qry = mysqli_query($con,"INSERT INTO tbl_initiator_query 
        								(initiator_user_name, initiator_msisdn, initiator_organization, initiator_city, tx_id, tx_type, tx_date, tx_time, tx_status, balance_before_tx, tx_amount, balance_after_tx, tx_effect, tx_channel, fee, fed, beneficiary_name, operator_msisdn, operator_name, customer_msisdn, customer_name, failed_reason, current_commission, current_wht, pos_id, third_party_tid, merchant_name, reversal_id, comment, do_name, addstatus, recorddate, uploadedby) VALUES 
        								('$initiator_user_name', '$initiator_msisdn', '$initiator_organization', '$initiator_city', '$tx_id', '$tx_type', '$tx_date', '$tx_time', '$tx_status', '$balance_before_tx', '$tx_amount', '$balance_after_tx','$tx_effect', '$tx_channel', '$fee', '$fed', '$beneficiary_name', '$operator_msisdn', '$operator_name', '$customer_msisdn', '$customer_name', '$failed_reason', '$current_commission', '$current_wht', '$pos_id', '$third_party_tid', '$merchant_name', '$reversal_id', '$comment', '$doName', '$addstatus', '$recorddate', '$uploadedby');
        								")or die(mysqli_query());
						        }
						            
						  }
						  
						    
						    
						    
						    
						    
							
							/*if($tx_type=='Transfer(B2B)')
							{
							    if($balance_before_tx > $balance_after_tx and $initiator_organization==$orgnization_name)
        							$tx_effect="Sent";
        						else if($balance_before_tx > $balance_after_tx)
        						    $tx_effect="Received";
        						else if ($balance_before_tx < $balance_after_tx)
        							$tx_effect="Sent";
        						else
        							$tx_effect="No Info";
							    $qury=mysqli_query($con,"SELECT * FROM retailers WHERE retailer_shop_name='$initiator_organization';")or die(mysqli_query());
							    //$qury=mysqli_query($con,"SELECT * FROM retailers WHERE do_line_number='$initiator_msisdn';")or die(mysqli_query());

								$data2=mysqli_fetch_array($qury);
								$doName=$data2['do_name'];
								$qry = mysqli_query($con,"INSERT INTO tbl_initiator_query 
								(initiator_user_name, initiator_msisdn, initiator_organization, initiator_city, tx_id, tx_type, tx_date, tx_time, tx_status, balance_before_tx, tx_amount, balance_after_tx, tx_effect, tx_channel, fee, fed, beneficiary_name, operator_msisdn, operator_name, customer_msisdn, customer_name, failed_reason, current_commission, current_wht, pos_id, third_party_tid, merchant_name, reversal_id, comment, do_name, addstatus, recorddate, uploadedby) VALUES 
								('$initiator_user_name', '$initiator_msisdn', '$initiator_organization', '$initiator_city', '$tx_id', '$tx_type', '$tx_date', '$tx_time', '$tx_status', '$balance_before_tx', '$tx_amount', '$balance_after_tx','$tx_effect', '$tx_channel', '$fee', '$fed', '$beneficiary_name', '$operator_msisdn', '$operator_name', '$customer_msisdn', '$customer_name', '$failed_reason', '$current_commission', '$current_wht', '$pos_id', '$third_party_tid', '$merchant_name', '$reversal_id', '$comment', '$doName', '$addstatus', '$recorddate', '$uploadedby');
								")or die(mysqli_query());
							}
							
							
							
							
							
							if($tx_type=='Cash in' OR $tx_type=='Cash out' OR $tx_type=='Collecting' OR $tx_type=='Indigo Bills (Postpaid payment)' OR $tx_type=='Remitting' OR $tx_type=='Utility Bills Payment')
							
							{
							   if($initiator_organization==$orgnization_name)
							    {
							    if($balance_before_tx > $balance_after_tx)
        							$tx_effect="Sent";
        						else if($balance_before_tx > $balance_after_tx)
        						    $tx_effect="Received";
        						else if ($balance_before_tx < $balance_after_tx)
        							$tx_effect="Sent";
        						else
        							$tx_effect="No Info";
							    $qury=mysqli_query($con,"SELECT * FROM retailers WHERE retailer_shop_name='$initiator_organization';")or die(mysqli_query());
								$data2=mysqli_fetch_array($qury);
								$doName=$data2['do_name'];
								$qry = mysqli_query($con,"INSERT INTO tbl_initiator_query 
								(initiator_user_name, initiator_msisdn, initiator_organization, initiator_city, tx_id, tx_type, tx_date, tx_time, tx_status, balance_before_tx, tx_amount, balance_after_tx, tx_effect, tx_channel, fee, fed, beneficiary_name, operator_msisdn, operator_name, customer_msisdn, customer_name, failed_reason, current_commission, current_wht, pos_id, third_party_tid, merchant_name, reversal_id, comment, do_name, addstatus, recorddate, uploadedby) VALUES 
								('$initiator_user_name', '$initiator_msisdn', '$initiator_organization', '$initiator_city', '$tx_id', '$tx_type', '$tx_date', '$tx_time', '$tx_status', '$balance_before_tx', '$tx_amount', '$balance_after_tx','$tx_effect', '$tx_channel', '$fee', '$fed', '$beneficiary_name', '$operator_msisdn', '$operator_name', '$customer_msisdn', '$customer_name', '$failed_reason', '$current_commission', '$current_wht', '$pos_id', '$third_party_tid', '$merchant_name', '$reversal_id', '$comment', '$doName', '$addstatus', '$recorddate', '$uploadedby');
								")or die(mysqli_query());
							    }
							}*/
							
							
							
						}
						//echo $initiator_organization ."   -->   ".$doName."</br>";
						//exit;
						if(! $qry )
							echo "<script type=\"text/javascript\">alert(\"Invalid File: Please Upload CSV File.\"); window.location = \"../mfsupload_iq.php\"</script>";
					}
				//1}
				$counter=$counter+1;
			}
	        fclose($file);
			//echo "<script type=\"text/javascript\"> alert(\"Data has been successfully added.\"); window.location = \"../mfsupload_iq.php\"</script>";
			echo "<script type=\"text/javascript\"> window.location = \"../mfsupload_iq.php\"</script>";
		}
		else
			echo "<script type=\"text/javascript\"> alert(\"No Data Found.\"); window.location = \"../mfsupload_iq.php\"</script>";
	}
?>