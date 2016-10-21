<?php
	if (!isset($_SESSION))
		session_start();
	print_r($_SESSION);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home Camagru</title>
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<?php include_once 'header.php' ?>
	<?php include_once 'footer.php' ?>
</body>
</html>