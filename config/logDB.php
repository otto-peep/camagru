<?php
	require 'database.php';
	try{
		$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "use DB_CAMAGRU;";
		$dbh->exec($sql);
	}
	catch (PDOException $e)
	{
		echo "Erreur:",$e->getMessage();
		die();
	}
