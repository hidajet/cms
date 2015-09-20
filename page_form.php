<?php 
require_once("sessions.php");
confirm_login();
if(!isset($new_page))
{
	$new_page=false;
}
?>
<p>Page name: 
<input type="text" id="menu_name" name="menu_name" value="<?php echo $select_page['menu_name']; ?>"/>
</p>
<p>Page position: 
<select name="position">
<?php
	if(!$new_page)
	{
		$pages = get_all_pages_for_subject($select_page['subject_id']);
		$count_page = mysql_num_rows($pages);
	}
	else
	{	
		$pages = get_all_pages_for_subject($select_sub['id']);
		$count_page= mysql_num_rows($pages)+1;
	}
	for($count=1; $count<=$count_page; $count++)
	{
		echo "<option value=\"{$count}\"";
		if($select_page['position']==$count)
		{
			echo "selected";
		}
		echo ">{$count}</option>";
	}
		
?>
</select>
</p>

<p>Visible: 
<input type="radio" name="visible" value="0"<?php if($select_page['visible']==0){echo " checked";} ?> />No
&nbsp;
<input type="radio" name="visible" value="1"<?php if($select_page['visible']==1){echo " checked";} ?> />Yes
</p>

<textarea name="content" rows="4" cols="30"><?php echo $select_page['content']; ?></textarea>
<br />
