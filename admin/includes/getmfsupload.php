<?
include_once('../../session.php');
include_once('variables.php');
include_once('globalvar.php');
if(isset($_POST["Import"]))
	{
		if ($_FILES["file"]["error"] > 0)
			{
				echo "Error: " . $_FILES["file"]["error"] . "<br>";
			}
		//echo $filename=$_FILES["file"]["tmp_name"];
		$filename=$_FILES["file"]["tmp_name"];
		if($_FILES["file"]["size"] > 0)
		{
		  	$file = fopen($filename, "r");
	        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
	        {
				$sheetData=array(trim($emapData[0]," "),trim($emapData[1]," "),trim($emapData[2]," "),trim($emapData[3]," "),trim($emapData[4]," "),trim($emapData[5]," "),trim($emapData[6]," "),trim($emapData[7]," "),);
				
				$qur=mysqli_query($con,"SELECT mfstrid FROM mfstransactions WHERE trid='$sheetData[0]' AND orgmsisdn='$sheetData[1]' ")or die(mysqli_query());
				$dat=mysqli_fetch_array($qur);
				if(! $dat )
				{
					if($emapData[4] > $emapData[6])
						$trType="Received";
					else if ($emapData[6] > $emapData[4])
						$trType="Sent";
					else
						$trType="No Info";
					
					$qury=mysqli_query($con,"SELECT DO FROM retailers WHERE number='$sheetData[1]' ")or die(mysqli_query());
					$data=mysqli_fetch_array($qury);
					$doName=$data['DO'];
					
					$qry = mysqli_query($con,"INSERT into mfstransactions (`trid`, `orgmsisdn`, `orgname`, `balbeforetr`, `tramnt`, `balaftertr`, `trtime`, `trtype`, `doname`, `addstatus`, `uploadedby`)
					values('$sheetData[0]','$sheetData[1]','$sheetData[2]','$sheetData[4]','$sheetData[5]','$sheetData[6]','$sheetData[7]','$trType','$doName', 'Pending', '$currentUser')")or die(mysqli_query());
						if(! $qry )
							echo "<script type=\"text/javascript\">alert(\"Invalid File: Please Upload CSV File.\"); window.location = \"../mfsupload.php\"</script>";
				}
			}
	        fclose($file);
			echo "<script type=\"text/javascript\"> alert(\"Data has been successfully added.\"); window.location = \"../mfsupload.php\"</script>";
		}
		else
			echo "<script type=\"text/javascript\"> alert(\"No Data Found.\"); window.location = \"../mfsupload.php\"</script>";
	}
?>