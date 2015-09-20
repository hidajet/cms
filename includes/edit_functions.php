<?php	
	function check_required_fields($fields, $post)
	{
		foreach($fields as $polje)
		{	//ispraviti greske
			if(!isset($post[$polje]) || empty($post[$polje]) || $post[$polje]="")
			{
				$errors[]=$polje;
			}	
		}
		return $errors;
	}

	function check_max_fields_length($fields, $post)
	{//ispraviti greske
		foreach($fields as $polje => $max_duz)
		{
			if(strlen(trim(mysql_prep($post[$polje])))>$max_duz)
			{
				$errors[]=$polje;
			}
		}
		return $errors;
	}

	function display_errors($error_array)
	{
		echo "<p class=\"greske\" style=\"color:red\">";
		echo "Please review the followinng fields:<br />";
		foreach($error_array as $greska)
		{
			echo " - ".$greska."<br />";
		}
		echo "</p>";
	}

?>
