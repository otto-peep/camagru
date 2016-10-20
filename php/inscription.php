<?php
	if ($_SESSION['rank'] == 1)
	{
		header("refresh:5;url=accueil.php");
		echo "Vous êtes déjà enregistré, vous allez être redirigé";
	}
	include_once('header.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Inscription camagru</title>
</head>
<body>
	<p> Bienvenue sur Camagru. Merci de renseigner les champs suivants pour vous enregistrer </p>
	<form action="createLogin.php" method="post">
		Identifiant: <input type="text" name="login" value="" placeholder="login"/> <br>
		Mot de passe: <input type="password" name="password" value="" placeholder="password"/> <br>
		Adresse email: <input type="email" name="email" value="" placeholder="adresse mail"/> <br>
		<input type="submit" name="submit" value="OK">
</body>
</html>