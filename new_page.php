
<?php 
include("includes/connection.php");
include("includes/functions.php");
include("includes/headers.php");

find_selected_page();


?>
<table id="structure">
<tr>
	<td id="navigation">
		<?php echo navigation($select_sub, $select_page); ?>
		<br />
		<a href="new_subject.php">+ Add a new subject </a>
	</td>
	<td id="page">
		<h2>Adding new page</h2>
		<?php 
		
			if(!empty($message))
			{
				echo "<p class=\"poruka\" style=\"color:green\">{$message}</p>";			
			}

			if(!empty($errors))
			{
				display_errors($errors);
			}
		
		?>
		<form action="create_page.php?subj=<?php echo $select_sub['id']; ?>" method="POST">
			<?php $new_page=true; ?>
			<?php include("page_form.php"); ?>
		
			<input type="submit" name="submit" value="Create page" />
			
		</form>
		<br />

		<a href="edit_sub.php?subj=<?php echo $select_sub['id']; ?>">Cancel</a> 
	</td>
</tr>
</table>

<?php 
include("includes/footers.php"); 
?>
