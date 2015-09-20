<?php
	require("includes/constants.php");	

	// 1. Kreiranje konekcije
	$conn=mysql_connect(DB_SERVER,DB_USER,DB_PASS);
	if(!$conn)
	{
		die("Ne mogu se konektovati na server ".mysql_error());
	}
	// 2. Odabir baze podataka
	$db=mysql_select_db(DB_NAME,$conn);
	if(!$db)
	{
		die("Ne mogu pronaci bazu podataka. Greska: ".mysql_error());
	}
?>
