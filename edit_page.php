
<?php 
include("includes/connection.php");
include("includes/functions.php");


if(intval($_GET['page'])==0)
{
	redirect_to("content.php");
}

include_once("includes/form_functions.php");

if(isset($_POST['submit']))
{
	$errors= array();
	$obavezna_polja=array('menu_name','position','visible','content');
	$errors=array_merge($errors,check_required_fields($obavezna_polja));
	
	$polje_sa_duzinom=array('menu_name'=>30);
	$errors=array_merge($errors,check_max_fields_length($polje_sa_duzinom));
	
	$id=mysql_prep($_GET['page']);
	$menu=mysql_prep($_POST['menu_name']);
	$position=mysql_prep($_POST['position']);
	$visible=mysql_prep($_POST['visible']);
	$content=mysql_prep($_POST['content']);
	
	$page_get=get_page_by_id($id);
	
	$pages_all=get_all_pages_for_subject($page_get['subject_id']);
	$page_fetch=mysql_fetch_array($pages_all);
	$count_pages=mysql_num_rows($pages_all);

	$position_old=$page_get['position'];
	
	if(empty($errors))
	{
		if($position_old != $position)
		{	
			if($position_old < $position)
			{
				for($i=$position_old; $i<$position; $i++)
				{
					$new=$i+1;
					$qry="UPDATE pages SET"; 
					$qry.=" position={$i}";					
					$qry.="	WHERE position={$new} AND subject_id={$page_get['subject_id']}";
					mysql_query($qry,$conn);
				}
			}
			else
			{
				for($i=$position_old; $i>$position; $i--)
				{
					$new=$i-1;
					$qry="UPDATE pages SET"; 
					$qry.=" position={$i}";					
					$qry.="	WHERE position={$new} AND subject_id={$page_get['subject_id']}";
					mysql_query($qry,$conn);
				}
			}
		}

		$query="UPDATE pages SET 
			menu_name='{$menu}',
			position={$position},
			visible={$visible},
			content='{$content}'
			WHERE id={$id}";
		$rezultat=mysql_query($query, $conn);
		if(mysql_affected_rows()==1)
		{
			$message="The page was successfully updated!";
		}
		else
		{
			$message="The page update failed <br />";
			$message.="Error:".mysql_error();
		}
	}
	else
	{
		if(count($errors)==1)
		{
			$message="There was 1 error in the form.";
		}
		else
		{
			$message.="<br />There are ".count($errors)." errors in the form!";
		}
	}
}
find_selected_page();
include("includes/headers.php");


?>
<table id="structure">
<tr>
	<td id="navigation">
		<?php echo navigation($select_sub, $select_page); ?>
	</td>
	<td id="page">
		<h2>Edit page: <?php echo " {$select_page['menu_name']}"; ?></h2>
		<?php 
			if(!empty($message))
			{
				echo "<p class=\"poruka\" style=\"color:orange\">{$message}</p>";			
			}

			if(!empty($errors))
			{
				display_errors($errors);
			}
		?>
		<form action="edit_page.php?page=<?php echo urlencode($select_page['id']); ?>" method="POST">
			
			<?php include("page_form.php"); ?>
			<input type="submit" value="Save page" name="submit" />

			&nbsp;&nbsp;
			<a href="delete_page.php?subj=<?php echo urlencode($select_page['id']); ?>"
			 onclick="return confirm('Are you sure you want to delete this page?')">Delete page</a>
		</form>
		<br />
		<a href="content.php?page=<?php echo $select_page['id'] ; ?>">Cancel</a>
		<br />

	</td>
</tr>
</table>

<?php 
include("includes/footers.php"); 
?>
