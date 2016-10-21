<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1 || $_POST['submit'] !== 'OK') 
	{
		header ('Location: accueil.php');
		exit();
	}
	include_once '../config/logDB.php';
	$password = hash(whirlpool, $_POST['passwd']);
	$login = $_SESSION['login'];
	$req = $dbh->prepare("SELECT * FROM usr WHERE login = :login && passwd = :passwd");
	$req->bindValue('login', $login, PDO::PARAM_STR);
	$req->bindValue('passwd', $password, PDO::PARAM_STR);
	$req->setFetchMode(PDO::FETCH_OBJ);
	$req->execute();
	if ($req->rowCount() !== 1)
	{
		header("refresh:3;url=compte.php");
		echo "Le mot de passe est erroné";
		exit();
	}
	else
	{
		$req = $dbh->prepare("DELETE FROM usr WHERE login = :login");
		$req->bindValue('login', $login, PDO::PARAM_STR);
		$req->execute();
		session_unset();
		header("refresh:3;url=accueil.php");
		echo "Votre compte a été supprimé";
	}

	
?>