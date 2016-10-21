<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1 || $_POST['submit'] !== 'OK')
	{
		header ('Location: accueil.php');
		exit();
	}
	$mail = $_POST['newmail'];
	else if (!isset($_POST['newmail'] || !filter_var($mail, FILTER_VALIDATE_EMAIL) || strlen($mail) > 40))
	{
		header ('refresh:3;url=compte.ph');
		echo "Mail invalide";
		exit();
	}
	$req = $dbh->prepare("UPDATE `usr` SET `mail` = :mail FROM usr WHERE login = :login");
	$req->bindValue('login', $_SESSION['login'], PDO::PARAM_STR);
	$req->bindValue('mail', $mail, PDO::PARAM_STR);
	$req->setFetchMode(PDO::FETCH_OBJ);
	$req->execute();
?>