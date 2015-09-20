<?php
require_once("includes/connection.php");
require_once("includes/functions.php");

if(intval($_GET['subj'])==0)
{
	redirect_to("content.php");
}

$id=mysql_prep($_GET['subj']);
if($page=get_page_by_id($id))
{
	$query="DELETE FROM pages WHERE id={$id} LIMIT 1";

	$result=mysql_query($query, $conn);
	if(mysql_affected_rows()==1)
	{
		$message="Page successfully deleted.";
		redirect_to("edit_sub.php");
	}
	else
	{
		//Deletion failed
		echo "<p>Page deletion failed.</p>";
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
