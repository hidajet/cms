<?php
require_once("includes/connection.php");
require_once("includes/functions.php");

if(intval($_GET['subj'])==0)
{
	redirect_to("content.php");
}

$id=mysql_prep($_GET['subj']);
if($subject=get_subject_by_id($id))
{
	$query="DELETE FROM subject WHERE id={$id} LIMIT 1";

	$result=mysql_query($query, $conn);
	if(mysql_affected_rows()==1)
	{
		$message="Record successfully deleted.";
		redirect_to("content.php");
	}
	else
	{
		//Deletion failed
		echo "<p>Subject deletion failed.</p>";
		echo "<p>".mysql_error()."</p>";
		echo "<a href=\"content.php\">Back to Main Page</a>";
	}
	
}
else
{
	//subject didn't exist in database
	redirect_to("content.php");
}


?>






<?php mysql_close($conn); ?>
