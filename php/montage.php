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
	<title>Montage</title>
</head>
<body>
	<?php include_once 'header.php' ?>
	<form action="saveimg.php" method="post" enctype="multipart/form-data">
    Select image to upload: <br/>
    <input type="radio" name="filter" id="nofilter"> Sans filtre <br/>
    <input type="radio" name="filter" id="griffes"> Griffes rouges <br/>
    <input type="radio" name="filter" id="Filtre3"> Filtre 3 <br/>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
	</form>
	<video id="video"></video>
	<button id="capture" onclick="takePicture()">Snapshot</button>
	<br/>
	<canvas id="canvas"></canvas>
	<img src="http://placekitten.com/" id="photo" alt="photo">
<script type="text/javascript" src="../js/montage.js"></script>
</body>
</html>