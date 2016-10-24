<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1)
	{
		header("refresh:1;url=connexion.php");
		echo "Vous devez d'abord vous connecter. Vous allez etre redirigé";
		exit();
	}
	ini_set("extension" , "php_gd2.dll"); 
	  // foreach(gd_info() as $key => $value) 
   //    echo "$key: <b>$value</b><br />"; 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Galerie</title>
		<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include_once 'header.php' ?>
<div class="boxcam">
    <input type="file" accept="image/*;capture=camera">
    <input type="button" id="capture" value="Prendre une photo" onclick="TakePicture();">
</div>

<script type="text/javascript">


</script>
</body>
</html>