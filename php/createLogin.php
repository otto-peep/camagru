<?php
	include '../config/logDB.php';
	if (!isset($_SESSION))
		session_start();
	if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login']))
	{
		$email = $_POST['email'];
		$password = $_POST['password'];
		$login = $_POST['login'];
		if(!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 40)
		{
			header("refresh:3;url=inscription.php");
			echo "L'adresse email n'est pas correcte";
			exit();
		}
		else if (strlen($login) > 15)
		{
			header("refresh:3;url=inscription.php");
			echo "Le pseudo est trop long";
			exit();
		}
		$req = $dbh->prepare("SELECT * FROM usr WHERE login = :login || mail = :mail");
		$req->bindValue('login', $login, PDO::PARAM_STR);
		$req->bindValue('mail', $email, PDO::PARAM_STR);
		$req->setFetchMode(PDO::FETCH_OBJ);
		$req->execute();
		if ($req->rowCount() > 0)
		{
			header("refresh:3;url=inscription.php");
			echo "Le login ou l'email existe deja";
			exit();
		}
		else
		{
			$password = hash(whirlpool, $password);
			$cle = md5(microtime(TRUE) * 100);
			$req = $dbh->prepare("INSERT INTO `usr` (`login`, `passwd`, `mail`, `cle`, `conf`) VALUES (:login, :password, :mail, :cle, 1)");
			$req->bindValue('login', $login, PDO::PARAM_STR);
			$req->bindValue('password', $password, PDO::PARAM_STR);
			$req->bindValue('mail', $email, PDO::PARAM_STR);
			$req->bindValue('cle', $cle, PDO::PARAM_STR);
			$req->setFetchMode(PDO::FETCH_OBJ);
			$req->execute();
			$destinataire = $email;
			$sujet = "Confirmation inscription CAMAGRU";
			$message = "Bonjour ".$login." Vous etes bien enregistré sur camagru.fr";
			$entete = "From: noreply@camagru.fr";
			mail($destinataire, $sujet, $message, $entete);
			header ("refresh:3;url=connexion.php");
			echo "Votre compte a été créé avec succès. Vous allez recevoir un mail de confirmation. <br/>
					Vous allez maintenant être redirigé vers la page de connexion";
		}
	}
	else
	{
		header("refresh:3;url=inscription.php");
		echo "Vous n'avez pas renseigné tous les champs, vous allez être redirigé";
		exit();
	}
?>