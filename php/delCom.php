<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1)
	{
		header("refresh:1;url=connexion.php");
		echo "Vous devez d'abord vous connecter. Vous allez etre redirigé";
		exit();
	}
	if (isset($_POST['id_img']) && isset($_POST['id_com']) && isset($_POST['delCom']))
	{
		include '../config/logDB.php';
		$log = $dbh->prepare("DELETE FROM `com` WHERE `com`.`id_img` = :id_img && `com`.`id_usr` = :id_usr && `com`.`id_com` = :id_com;");
		$log->bindValue('id_img', $_POST['id_img'], PDO::PARAM_INT);
		$log->bindValue('id_com', $_POST['id_com'], PDO::PARAM_INT);
		$log->bindValue('id_usr', $_SESSION['id_usr'], PDO::PARAM_INT);
		$log->setFetchMode(PDO::FETCH_OBJ);
		$log->execute();
		header('Location: galerie.php');
		exit();
	}
	else
	{
		header("refresh:2;url=galerie.php");
		echo "Il y a eu un probleme dans la suppression de votre commentaire. Vous allez etre redirigé";
		exit();	
	}
?>