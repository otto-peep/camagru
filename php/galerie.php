 <?php
	if (!isset($_SESSION))
		session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Galerie</title>
		<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<?php include_once 'header.php'; ?>
	
	<h3> Bienvenue dans la galerie <?php if ($_SESSION['login']) echo $_SESSION['login'];?> </h3><br/>
	<?php include_once 'mosaique.php'; ?>
	<?php include_once 'footer.php' ?>

<script type="text/javascript">

</script>
</body>
</html>