<?php
session_start();

function confirm_login()
{
	if(!isset($_SESSION['user_id']))
	{
		redirect_to("login.php");
	}

}
?>
