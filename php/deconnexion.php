<?php
	header("refresh:5;url=accueil.php");
	include_once 'header.php';
	if (!$_SESSION['login'])
		echo "<h2>Vous êtes déjà déconnecté, vous allez être redirigé vers l'accueil.</h2>";
	else
	{
		$login = $_SESSION['login'];
		$_SESSION['login'] = '';
		$_SESSION['rank'] = 0;
		echo "<h2>Vous avez été déconnecté. Revenez vite".$login.".</h2> <br>Vous allez être redirigé vers l'accueil.";
	}
	include_once 'footer.php';
?>