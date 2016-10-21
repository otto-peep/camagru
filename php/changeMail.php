<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1 || $_POST['submit'] !== 'OK')
	{
		header ('Location: accueil.php');
		exit();
	}
	else if (!isset($_POST['newmail']) || !filter_var($_POST['newmail'], FILTER_VALIDATE_EMAIL) || strlen($_POST['newmail']) > 40)
	{
		header ('refresh:3;url=compte.php');
		echo "Mail invalide";
		exit();
	}
	else
	{
		include_once '../config/logDB.php';
		$mail = $_POST['newmail'];
		$req = $dbh->prepare("SELECT * FROM `usr` WHERE mail = :mail"); //on cherche dans la db si l'email existe -> pas de doublon
		$req->bindValue('mail', $mail, PDO::PARAM_STR);
		$req->setFetchMode(PDO::FETCH_OBJ);
		$req->execute();
		if ($req->rowCount() == 0)
		{
			$req = $dbh->prepare("UPDATE `usr` SET `mail` = :mail WHERE login = :login"); // on update dans la db l'email
			$req->bindValue('login', $_SESSION['login'], PDO::PARAM_STR);
			$req->bindValue('mail', $mail, PDO::PARAM_STR);
			$req->setFetchMode(PDO::FETCH_OBJ);
			$req->execute();
		}
		else
		{
			header ('refresh:2;url=compte.php');
			echo "Ce mail existe deja dans la base de données.";
			exit();
		}


	}	
?>