<?php
	if (!isset($_SESSION))
		session_start();
	//print_r($_SESSION);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home Camagru</title>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/header.css">
</head>
<body>
	<?php include 'header.php' ?>
	<br/>
	login: monsieurzer
	password: helloworld
	<?php include 'footer.php' ?>
</body>
</html>