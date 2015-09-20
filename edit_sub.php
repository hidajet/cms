
<?php 
include("includes/connection.php");
include("includes/functions.php");
include("includes/headers.php");



if(intval($_GET['subj'])==0)
{
	redirect_to("content.php");
}


if(isset($_POST['submit']))
{
	$errors= array();
	$obavezna_polja=array('menu_name','position','visible');
	foreach($obavezna_polja as $polje)
	{
		if(!isset($_POST[$polje]) || (empty($_POST[$polje]) && $_POST[$polje]!=0)  || $_POST[$polje]=="")
		{
			$errors[]=$polje;
		}	
	}
	$polje_sa_duzinom=array('menu_name'=>30);
	foreach($polje_sa_duzinom as $polje => $max_duz)
	{
		if(strlen(trim(mysql_prep($_POST[$polje])))>$max_duz)
		{
			$errors[]=$polje;
		}
	}
	
	if(empty($errors))
	{
		$id=mysql_prep($_GET['subj']);
		$menu=mysql_prep($_POST['menu_name']);
		$position=mysql_prep($_POST['position']);
		$visible=mysql_prep($_POST['visible']);
		
		$rez = get_subject_by_id($_GET['subj']);
		$position_old = $rez['position'];


		if($position_old != $position)
		{	
			if($position_old < $position)
			{
				for($i=$position_old; $i<$position; $i++)
				{
					$new=$i+1;
					$qry="UPDATE subject SET"; 
					$qry.=" position={$i}";					
					$qry.="	WHERE position={$new}"; 
					mysql_query($qry,$conn);
				}
			}
			else
			{
				for($i=$position_old; $i>$position; $i--)
				{
					$new=$i-1;
					$qry="UPDATE subject SET"; 
					$qry.=" position={$i}";					
					$qry.="	WHERE position={$new}";
					mysql_query($qry,$conn);
				}
			}
		}

		

		$query="UPDATE subject SET 
			menu_name='{$menu}',
			position={$position},
			visible={$visible}
			WHERE id={$id}";
		$rezultat=mysql_query($query, $conn);
		if(mysql_affected_rows()==1)
		{
			$message="The subject was successfully updated!";
		}
		else
		{
			$message="The subject update failed <br />";
			$message.="Error:".mysql_error();
		}
	}
	else
	{
		$message="Please enter required fields.";
		$message.="<br />There are ".count($errors)." errors in the form!";
	}
}
find_selected_page();



?>
<table id="structure">
<tr>
	<td id="navigation">
		<?php echo navigation($select_sub, $select_page); ?>
	</td>
	<td id="page">
		<h2>Edit subject: <?php echo " {$select_sub['menu_name']}"; ?></h2>
		<?php 
			if(!empty($message))
			{
				echo "<p class=\"poruka\" style=\"color:green\">{$message}</p>";			
			}

			if(!empty($errors))
			{
				echo "<p class=\"greske\" style=\"color:red\">";
				echo "Please review the followinng fields:<br />";
				foreach($errors as $greska)
				{
					echo " - ".$greska."<br />";
				}
				echo "</p>";			
			}		
		?>
		<form action="edit_sub.php?subj=<?php echo urlencode($select_sub['id']); ?>" method="POST">
			<p>Subject name: 
			<input type="text" id="menu_name" name="menu_name" value="<?php echo $select_sub['menu_name']; ?>"/>
			</p>
			<p>Subject position: 
			<select name="position">
			<?php
				$subjects = get_all_subjects();
				$count_sub = mysql_num_rows($subjects);
				for($count=1; $count<=$count_sub; $count++)
				{
					echo "<option value=\"{$count}\"";
					if($select_sub['position']==$count)
					{
						echo "selected";
					}
					echo ">{$count}</option>";
				}	
				
			?>
			</select>
			</p>

			<p>Visible: 
			<input type="radio" name="visible" value="0"<?php if($select_sub['visible']==0){echo " checked";} ?> />No
			&nbsp;
			<input type="radio" name="visible" value="1"<?php if($select_sub['visible']==1){echo " checked";} ?> />Yes
			</p>
		
			<input type="submit" value="Save subject" name="submit" />

			&nbsp;&nbsp;
			<a href="delete_sub.php?subj=<?php echo urlencode($select_sub['id']); ?>"
			 onclick="return confirm('Are you sure?')">Delete subject</a>
		</form>
		
		<br />
		<a href="content.php">Cancel</a>
		<br />
		
		<div>
			<h3>Pages in this subject</h3>
			<ul>
			
			<?php
				$sub_pages=get_all_pages_for_subject($select_sub['id']);
				while($page=mysql_fetch_array($sub_pages))
				{
					echo "<li><a href=\"content.php?page={$page['id']}\">{$page['menu_name']}</a></li>";
				}
					
			?>
			</ul>
			<br />
			<a href="new_page.php?subj=<?php echo $select_sub['id']; ?>">+ Add a new page to this subject</a>
		</div>
		
	
	</td>
</tr>
</table>

<?php 
include("includes/footers.php"); 
?>
