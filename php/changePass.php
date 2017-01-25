<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1 || $_POST['submit'] !== 'OK')
	{
		header ('Location: accueil.php');
		exit();
	}
	else if (!$_POST['oldpw'] || !$_POST['newpw'] || strlen($_POST['newpw']) > 30 || strlen($_POST['newpw'] < 6))
	{
		header ('refresh:3;url=compte.php');
		echo "Nouveau mot de passe invalide, vous devez remplir les champs correctement.";
		exit();
	}
	else
	{
		include_once '../config/logDB.php';
		$mail = $_POST['newmail'];
		$oldpw = hash(whirlpool, $_POST['oldpw']);
		$newpw = hash(whirlpool, $_POST['newpw']);
		$req = $dbh->prepare("SELECT * FROM `usr` WHERE login = :login");
		$req->bindValue('login', $_SESSION['login'], PDO::PARAM_STR);
		$req->setFetchMode(PDO::FETCH_OBJ);
		$req->execute();
		$results = $req->fetch();
		if ($results->passwd !== $oldpw)
		{
			header('refresh:3;url=compte.php');
			echo "Ancien mot de passe erroné";
			exit();
		}
		else
		{
			$req = $dbh->prepare("UPDATE `usr` SET `passwd` = :passwd WHERE login = :login");
			$req->bindValue('login', $_SESSION['login'], PDO::PARAM_STR);
			$req->bindValue('passwd', $newpw, PDO::PARAM_STR);
			$req->setFetchMode(PDO::FETCH_OBJ);
			$req->execute();
			header('refresh:3;url=compte.php');
			echo "Le mot de passe a été modifié.";
		}
	}	
?>