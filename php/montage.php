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
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<?php include_once 'header.php' ?>
	
	<form action="checkfile.php" method="post" enctype="multipart/form-data" id='formUpload' name='upload'>
    Select image to upload: <br/>
    <input type="text" maxlength="200" id='desc' name="description" placeholder="description"> <br/>
    <input type="radio" name="filter" value="thumbup"> Thumbup <br/>
    <input type="radio" name="filter" value="griffes"> Griffes rouges <br/>
    <input type="radio" name="filter" value="troll"> Trollface <br/>
    <input type="file"  value="fileToUpload" name="fileToUpload" id="fileToUpload">
    </form>
    <button onclick='uploadPhoto();'> Upload file</button><br/>
	<video id="video"></video>
	<button id="capture">Snapshot</button>
	<br/>
	<canvas id="canvas"></canvas>
	<?php include 'usrmosaique.php' ; ?>
	<?php include 'footer.php' ;?>
<script type="text/javascript" src="../js/montage.js"></script>
</body>
</html>