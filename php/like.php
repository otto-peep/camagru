<?php
	if (!isset($_SESSION))
		session_start();
	
	if ($_SESSION['rank'] !== 1)
	{
		header("refresh:1;url=connexion.php");
		echo "Vous devez d'abord vous connecter. Vous allez etre redirigé";
		exit();
	}
	include '../config/logDB.php';
	if ($_POST['like'])
		$log = $dbh->prepare("INSERT INTO `likes` (`id_like`, `id_usr`, `id_img`) VALUES (NULL, :id_usr, :id_img);");
	else if ($_POST['dislike'])
		$log = $dbh->prepare("DELETE FROM `likes` WHERE `likes`.`id_img` = :id_img && `likes`.`id_usr` = :id_usr;");
	$log->bindValue('id_img', $_POST['id_img'], PDO::PARAM_INT);
	$log->bindValue('id_usr', $_SESSION['id_usr'], PDO::PARAM_INT);
	$log->setFetchMode(PDO::FETCH_OBJ);
	$log->execute();

	header('Location: galerie.php');
?>