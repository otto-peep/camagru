<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1)
	{
		header("refresh:2;url=accueil.php");
		echo "Vous n'avez rien à faire ici, vous allez etre redirigé";
		exit ();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Compte</title>
		<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<?php include_once 'header.php' ?>
	<div class = 'compte'>
		<div class='title'> Changement de mot de passe: </div>
		<div class='contenu'>
			<form action="changePass.php" method="post">
				Ancien mot de passe: <input type="password" name="oldpw" value="" placeholder="oldpw">
				<div id='newpwd'>
				Nouveau mot de passe: <input type="password" name="newpw" value="" placeholder="newpw">
				<input type="submit" name="submit" value="OK">
				</div>
			</form>
		</div>
		<div class = 'title'>Changement d'adresse mail: </div>
		<div class='contenu'>
			<form action="changeMail.php" method="post">
				Nouvel adresse mail: <input type="email" name="newmail" value="" placeholder="newmail">
				<input type="submit" name="submit" value="OK">
			</form>
		</div>

		<div class = 'title'>Suppression du compte</div>
		<div class ='contenu'>
			<form action="delLogin.php" method="post">
			<input type="password" name="passwd" value="" placeholder="type your pw for validation">
			<input type="submit" name="submit" value="OK">
			</form>
		</div>
	</div>
</body>
</html>