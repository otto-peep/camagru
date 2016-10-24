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
			  `date_com` datetime NOT NULL,
			  `com` varchar(255) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	
	$img = "CREATE TABLE `img` (
			  `id_img` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  `path_img` varchar(255) NOT NULL,
			  `id_usr` int(10) NOT NULL,
			  `date_img` DATETIME NOT NULL,
			  `description` varchar(255) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	
	$likes = "CREATE TABLE `likes` (
			  `id_like` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  `id_usr` int(10) UNSIGNED NOT NULL,
			  `id_img` int(10) UNSIGNED NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

	$root_usr = "INSERT INTO `usr` (`id_usr`, `login`, `passwd`, `mail`, `cle`, `conf`) VALUES (NULL, 'pconin', '74dfc2b27acfa364da55f93a5caee29ccad3557247eda238831b3e9bd931b01d77fe994e4f12b9d4cfa92a124461d2065197d8cf7f33fc88566da2db2a4d6eae', 'pconin@student.42.fr', '1', '1');";

	$img_ville = "INSERT INTO `img` (`id_img`, `path_img`, `id_usr`, `date_img`, `description`) VALUES (NULL, '../img/ville.jpg', '1', '2014-05-23T14:25:10', 'Ville de paris');";
	
	$img_ecole = "INSERT INTO `img` (`id_img`, `path_img`, `id_usr`, `date_img`, `description`) VALUES (NULL, '../img/ecole.jpg', '1', '2016-04-23T14:25:10', 'Cluster 2');";

	$com_ville1 = "INSERT INTO `com` (`id_com`, `id_usr`, `id_img`, `date_com`, `com`) VALUES (NULL, '1', '1', '2016-10-23T13:33:20', 'What a nice place!');";
	$com_ville2 = "INSERT INTO `com` (`id_com`, `id_usr`, `id_img`, `date_com`, `com`) VALUES (NULL, '1', '1', '2016-10-25T13:33:20', 'Isnt it?');";

	$like_ville1 = "INSERT INTO `likes` (`id_like`, `id_usr`, `id_img`) VALUES (NULL, '1', '1');";
	$like_ville2 = "INSERT INTO `likes` (`id_like`, `id_usr`, `id_img`) VALUES (NULL, '2', '1');";
	$like_ecole1 = "INSERT INTO `likes` (`id_like`, `id_usr`, `id_img`) VALUES (NULL, '1', '2');";
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
		$db->exec($img_ville);
		$db->exec($img_ecole);
		$db->exec($com_ville1);
		$db->exec($com_ville2);
		$db->exec($like_ville1);
		$db->exec($like_ville2);
		$db->exec($like_ecole1);
	}
	catch (PDOException $e)
	{
		echo "error", $e->getMessage().'<br/>';
	}
?>