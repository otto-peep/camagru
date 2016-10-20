<?php
	include_once'database.php';
	try
	{
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (Exception $e)
	{
		echo "Echec " . $e->getMessage();
		die ();
	}
	echo "DB successfully created";
	
	$drop = "DROP DATABASE IF EXISTS DB_CAMAGRU;";

	$create = "CREATE DATABASE DB_CAMAGRU;";

	$use = "USE DB_CAMAGRU;";

	$usr = "CREATE TABLE `usr` (
			  `id_usr` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  `login` varchar(15) NOT NULL,
			  `passwd` char(128) NOT NULL,
			  `mail` varchar(40) NOT NULL,
			  `cle` char(32) NOT NULL,
  				`conf` int(2) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	
	$com = "CREATE TABLE `com` (
			  `id_com` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
			  `id_usr` int(10) UNSIGNED NOT NULL,
			  `id_img` int(10) UNSIGNED NOT NULL,
			  `date_com` date NOT NULL,
			  `com` varchar(255) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	
	$img = "CREATE TABLE `img` (
			  `id_img` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  `path_img` varchar(255) NOT NULL,
			  `id_usr` int(10) NOT NULL,
			  `date_img` date NOT NULL,
			  `description` varchar(255) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	
	$likes = "CREATE TABLE `likes` (
			  `id_like` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  `id_usr` int(10) UNSIGNED NOT NULL,
			  `id_img` int(10) UNSIGNED NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

	$root_usr = "INSERT INTO `usr` (`id_usr`, `login`, `passwd`, `mail`) VALUES (NULL, 'pconin', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'pconin@student.42.fr');";

	// create db
	try
	{
		$db->exec($drop);
		$db->exec($create);
		$db->exec($use);
	}
	catch (PDOException $e)
	{
		echo "error", $e->getMessage().'<br/>';
	}

	// create table
	try
	{
		$db->exec($usr);
		$db->exec($com);
		$db->exec($img);
		$db->exec($likes);
	}
	catch (PDOException $e)
	{
		echo "error", $e->getMessage().'<br/>';
	}
	// insert data in table
	try
	{
		$db->exec($root_usr);
	}
	catch (PDOException $e)
	{
		echo "error", $e->getMessage().'<br/>';
	}
?>