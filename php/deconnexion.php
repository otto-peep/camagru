<head>
		<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/header.css">
</head>
<?php
	header("refresh:2;url=accueil.php");
	include_once 'header.php';
	if (!$_SESSION['login'])
		echo "<h2>Vous êtes déjà déconnecté, vous allez être redirigé vers l'accueil.</h2>";
	else
	{
		session_unset();
		echo "<h2>Vous avez été déconnecté. Revenez vite".$login.".</h2> <br>Vous allez être redirigé vers l'accueil.";
	}
	include_once 'footer.php';
?>