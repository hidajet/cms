<?php 
include("includes/connection.php");
include("includes/functions.php");


//validacija forme
if(intval($_GET['subj'])==0)
{
	redirect_to("content.php");
}
	$errors= array();
	$obavezna_polja=array("menu_name","position","visible","content");
	foreach($obavezna_polja as $polje)
	{
		if(!isset($_POST[$polje]) || (empty($_POST[$polje]) && $_POST[polje]!=0))
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
		redirect_to("new_page.php");
	}

	$menu_name=mysql_prep($_POST["menu_name"]);
	$position=mysql_prep($_POST["position"]);
	$visible=mysql_prep($_POST["visible"]);
	$content=mysql_prep($_POST["content"]);
	$subject_id=mysql_prep($_GET["subj"]);

	$query="INSERT INTO pages (menu_name, position, visible,content, subject_id) VALUES ('{$menu_name}',{$position},{$visible},'{$content}',{$subject_id})";
	if(mysql_query($query, $conn))
	{
		echo "Page added successfully. <br />";
		redirect_to("edit_sub.php?subj={$_GET['subj']}");
	}
	else
	{
		echo "<p>Page insertation failed. </p>";
		echo "<p>Error: ".mysql_error()."</p>";
	}	

?>

<?php
	mysql_close($conn);
?>
