
<?php 
include("includes/connection.php");
include("includes/functions.php");
include("includes/form_functions.php");

if(isset($_POST['submit']))
{
	$errors= array();
	$obavezna_polja=array("user","pass");
	
	$errors=array_merge($errors, check_required_fields($obavezna_polja));
	
	$polja_sa_duzinom=array("user"=>30, "pass"=>30);
	$errors=array_merge($errors, check_max_fields_length($polja_sa_duzinom));
	
	$username=mysql_prep($_POST['user']);
	$password=mysql_prep($_POST['pass']);
	$hashed_pass=sha1($password);
	

	$query="INSERT INTO users (username,password) VALUES ('{$username}','{$hashed_pass}')";
	if(mysql_query($query, $conn))
	{
		$message="User added successfully.";
		
	}
	else
	{
		$message="User insertation failed.";
		$message.="Error: ".mysql_error();
	}	
}
include("includes/headers.php");


?>
<table id="structure">
<tr>
	<td id="navigation">
		
		<a href="staff.php">Return To Main Menu</a>
	</td>
	<td id="page">
		<h2>Add new user</h2>
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
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<input type="text" name="user" placeholder="Username" />
			<input type="password" name="pass" placeholder="Password" />
		
			<input type="submit" name="submit" value="Create user" />
			
		</form>
		<br />

		<a href="staff.php">Back</a> 
	</td>
</tr>
</table>

<?php 
include("includes/footers.php"); 
?>
