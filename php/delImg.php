<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1)
	{
		header("refresh:1;url=connexion.php");
		echo "Vous devez d'abord vous connecter. Vous allez etre redirigé";
		exit();
	}
	if (isset($_POST['id_img']) && isset($_POST['delImg']))
	{
		include '../config/logDB.php';
		$log = $dbh->prepare("DELETE FROM `com` WHERE `com`.`id_img` = :id_img;");
		$log->bindValue('id_img', $_POST['id_img'], PDO::PARAM_INT);
		$log->execute();
		$log = $dbh->prepare("DELETE FROM `img` WHERE `img`.`id_img` = :id_img;");
		$log->bindValue('id_img', $_POST['id_img'], PDO::PARAM_INT);
		$log->execute();
		$log = $dbh->prepare("DELETE FROM `likes` WHERE `likes`.`id_img` = :id_img;");
		$log->bindValue('id_img', $_POST['id_img'], PDO::PARAM_INT);
		$log->execute();
		header("refresh:1;url=galerie.php");
		echo "Votre image a bien été supprimée. Vous allez etre redirigé";
		exit();	
	}
	else
	{
		header("refresh:2;url=galerie.php");
		echo "Il y a eu un probleme dans la suppression de l'image. Vous allez etre redirigé";
		exit();	
	}
?>