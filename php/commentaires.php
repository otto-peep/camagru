<?php
	if (!isset($_SESSION))
		session_start();
	
	if ($_SESSION['rank'] !== 1)
	{
		header("refresh:1;url=connexion.php");
		echo "Vous devez d'abord vous connecter. Vous allez etre redirigé";
		exit();
	}
	if (isset($_POST['id_img']) && isset($_POST['com']) && isset($_POST['addCom']) && strlen($_POST['com'] < 255))
	{
		include '../config/logDB.php';
		$log = $dbh->prepare("INSERT INTO `com` (`id_com`, `id_usr`, `id_img`, `date_com`, `com`) VALUES (NULL, :id_usr, :id_img, NOW(), :com);");
		$log->bindValue('id_img', $_POST['id_img'], PDO::PARAM_INT);
		$log->bindValue('id_usr', $_SESSION['id_usr'], PDO::PARAM_INT);
		$log->bindValue('com', $_POST['com'], PDO::PARAM_STR);
		$log->setFetchMode(PDO::FETCH_OBJ);
		$log->execute();

		//envoi de l'email de notification
		include_once 'functions.php';
		$mail = get_mail($_POST['id_img']);
		$sujet = "Commentaire photo CAMAGRU";
		$message = "Bonjour,\nune de vos photo sur Camagru a été commentée par ".$_SESSION['login']."\nConnectez vous vite!";
		$entete = "From: noreply@camagru.fr";
		mail($mail, $sujet, $message, $entete);
		header('Location: galerie.php');
	}
	else
	{
		header("refresh:2;url=galerie.php");
		echo "Il y a eu un probleme dans l'envoi de votre commentaire. Vous allez etre redirigé";
		exit();	
	}
?>