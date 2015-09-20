<?php require_once("sessions.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_login(); ?>

<!DOCTYPE html>
<html>

	<head>
		<title>Staff Page</title>
		<link href="css/cms.css" rel="stylesheet" type="text/css" />
	</head>

	<body>
		<div id="header">
			<h1>Hide & Co</h1>
		</div>

		<div id="main">
			<table id="structure">
			<tr>
				<td id="navigation"> &nbsp;</td>
				<td id="page">
					<h2>Staff menu</h2>
					<p>Welcome to staff page. <?php echo $_SESSION['username']; ?></p>
					<ul>
						<li><a href="content.php">Manage Page Content</a></li>
						<li><a href="new_user.php">Add staff user</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</td>
			</tr>
			</table>
		</div>

		<div id="footer">Copyright 2015, Hidajet Husicic</div>
	</body>

</html>
