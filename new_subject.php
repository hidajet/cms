
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
	</td>
	<td id="page">
		<h2>Add subject</h2>
		<form action="create_sub.php" method="POST">
			<p>Subject name: 
			<input type="text" id="menu_name" name="menu_name" value=""/>
			</p>
			<p>Subject position: 
			<select name="position">
			<?php
				$subjects=get_all_subjects();
				$count_sub=mysql_num_rows($subjects);
				for($count=1; $count<=$count_sub+1; $count++)
				{
					echo "<option value=\"{$count}\">{$count}</option>";
				}	
				
			?>
			</select>
			</p>

			<p>Visible: 
			<input type="radio" name="visible" value="0"/>No
			&nbsp;
			<input type="radio" name="visible" value="1"/>Yes
			</p>
		
			<input type="submit" value="Add subject" />
		</form>

	</td>
</tr>
</table>

<?php 
include("includes/footers.php"); 
?>
