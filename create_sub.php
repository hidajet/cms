<?php 
include("includes/connection.php");
include("includes/functions.php");

?>

<?php
	// Validacija forme
/*
	if(!isset($_POST["menu_name"]) || empty($_POST["menu_name"]))
	{
		$errors[]='menu_name';	
	}
	if(!isset($_POST["position"]) || empty($_POST["position"]))
	{
		$errors[]='position';	
	}
	if(!empty($errors))
	{
		redirect_to("new_subject.php");
	}
*/
	$errors= array();
	$obavezna_polja=array("menu_name","position","visible");
	foreach($obavezna_polja as $polje)
	{
		if(!isset($_POST[$polje]) || (empty($_POST[$polje]) && $_POST[$polje] !=0))
		{
			$errors[]=$polje;
		}	
	}
	$polje_sa_duzinom=array("menu_name"=>30);
	foreach($polje_sa_duzinom as $polje => $max_duz)
	{
		if(strlen(trim(mysql_prep($_POST[$polje])))>$max_duz)
		{
			$errors[]=$polje;
		}
	}
	if(!empty($errors))
	{
		redirect_to("new_subject.php");
	}
?>

<?php
	$menu_name=mysql_prep($_POST["menu_name"]);
	$position=mysql_prep($_POST["position"]);
	$visible=mysql_prep($_POST["visible"]);

	$query="INSERT INTO subject (menu_name, position, visible) VALUES ('{$menu_name}',{$position},{$visible})";
	if(mysql_query($query, $conn))
	{
		echo "Subject added successfully. <br />";
		redirect_to("content.php");
	}
	else
	{
		echo "<p>Subject insertation failed. </p>";
		echo "<p>Error: ".mysql_error()."</p>";
	}	

?>

<?php
	mysql_close($conn);
?>
