<?php
$tmptxttbl_cardsRate=97;
if(isset($_POST['SaveData']))
{
	
	//$tmpdoSelect=$_POST['doSelect'];
	$tmptxtCardQty=$_POST['txtCardQty'];
	$tmptxttbl_cardsRate=$_POST['txttbl_cardsRate'];
	$tmptxtmfsSend=$_POST['txtmfsSend'];
	$tmptxtmfsReceive=$_POST['txtmfsReceive'];
	$tmptxtLoad=$_POST['txtLoad']; 
}
if(isset($_POST['Reset']))
{
	
	$tmpdoSelect="";
	$tmptxtCardQty="";
	$tmptxttbl_cardsRate=$_POST['txttbl_cardsRate'];
	$tmptxtmfsSend="";
	$tmptxtmfsReceive="";
	$tmptxtLoad=""; 
}	
?>