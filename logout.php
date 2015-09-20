<?php
require_once("includes/functions.php");

//find the session
session_start();
//unset all the session variables
$_SESSION =array();
//destroy the session cookie
if(isset($_COOKIE[session_name]))
{
	setcookie(session_name, '', time()-42000,'/');
}
//destroy the session
session_destroy();

redirect_to("login.php?logout=1");
?>
