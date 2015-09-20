<?php

function check_required_fields($required)
{
	$field_errors= array();
	foreach($required as $fields)
	{
		if(!isset($_POST[$fields]) || (empty($_POST[$fields]) && $_POST[$fields]!=0))
		{	
			$field_errors[]=$fields;		
		}
	}
	return $field_errors;
}

function check_max_fields_length($field_length_array)
{
	$field_errors= array();
	foreach($field_length_array as $fields => $max_len)
	{
		if(strlen(trim(mysql_prep($_POST[$fields])))>$max_len)
		{
			$field_errors[]=$fields;
		}
	}
	return $field_errors;
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
