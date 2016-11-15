<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] === 1)
	{
		header("refresh:5;url=accueil.php");
		echo "Vous êtes déjà enregistré, vous allez être redirigé";
		exit ();
	}
	if ($_POST['submit'])
	{
		if (!$_POST['passwd'] || !$_POST['login'] || $_POST['submit'] != 'OK')
		{
			header("refresh:5;url=connexion.php");
			echo "Vous devez remplir tous les champs";
			exit ();
		}
		else
		{
			include '../config/logDB.php';
			$login = $_POST['login'];
			$password = hash(whirlpool, $_POST['passwd']);
			$req = $dbh->prepare("SELECT * FROM usr WHERE login = :login && passwd = :passwd && conf = 1");
			$req->bindValue('login', $login, PDO::PARAM_STR);
			$req->bindValue('passwd', $password, PDO::PARAM_STR);
			$req->setFetchMode(PDO::FETCH_OBJ);
			$req->execute();
			$results = $req->fetch();
			if ($req->rowCount() != 1)
			{
				header("refresh:5;url=connexion.php");
				echo "Mot de passe/pseudo invalide, vous allez etre redirigé";
				exit ();
			}
			else
			{
				$_SESSION['login'] = $login;
				$_SESSION['rank'] = 1;
				$_SESSION['mail'] = $results->mail;
				$_SESSION['id_usr'] = $results->id_usr;
				header("refresh:3;url=accueil.php");
				echo "<h1>Bienvenue ".$login." Vous allez être redirigé vers l'accueil!</h1>";

			}
		}

	}
	include_once('header.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Connexion Camagru</title>
	
</head>
<body>
	<form action="connexion.php" method="post">
	Identifiant: <input type="text" name="login" value="" placeholder="login"/> <br/>
	Mot de passe: <input type="password" name="passwd" value="" placeholder="password"/>
	<input type="submit" name="submit" value="OK">
	</form><br/>
	<a href="forgivepwd.php">Mot de passe oublié ?</a>
</body>
</html>