
<?php 
include("sessions.php");
include("includes/connection.php");
include("includes/functions.php");

if(isset($_POST['submit']))
{
	$errors= array();
	$obavezna_polja=array("user","pass");
	
	$errors=array_merge($errors, check_required_fields($obavezna_polja, $_POST));
	
	$polja_sa_duzinom=array("user"=>30, "pass"=>30);
	$errors=array_merge($errors, check_max_fields_length($polja_sa_duzinom, $_POST));
	$username=mysql_prep($_POST['user']);
	$password=mysql_prep($_POST['pass']);
	$hashed_pass=sha1($password);
	
	if(empty($errors))
	{
		$query="SELECT id,username FROM users ";
		$query.=" WHERE username='{$username}' AND password='{$hashed_pass}'";
		$query.=" LIMIT 1";
		$result=mysql_query($query,$conn);
		confirm_query($result);
		if(mysql_num_rows($result)==1)
		{
			$message="Found user.";
			$found_user=mysql_fetch_array($result);
			//$_COOKIE['user_id']=$found_user['id'];
			$_SESSION['user_id']=$found_user['id'];
			$_SESSION['username']=$found_user['username'];
			redirect_to("staff.php");
		
		}
		else
		{
			$message="Username/password combination incorrect.<br />";
			$message.="Please make sure your caps lock keys are turned off and try again!" ;
		}
	}
		
}
else
{
	if(isset($_GET['logout']) && $_GET['logout']==1)
	{
		$message="You are now logged out.";
	}
	$username="";
	$password="";
}
include("includes/headers.php");


?>
<table id="structure">
<tr>
	<td id="navigation">
		
		<a href="staff.php">Return To Main Menu</a>
	</td>
	<td id="page">
		<h2>Log in</h2>
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
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<input type="text" name="user" placeholder="Username" />
			<input type="password" name="pass" placeholder="Password" />
		
			<input type="submit" name="submit" value="Login" />
			
		</form>
		<br />

		<a href="staff.php">Back</a> 
	</td>
</tr>
</table>

<?php 
include("includes/footers.php"); 
?>
