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
<?php include_once 'header.php'; ?>
<div class="boxcam">
<form method="post" action="upload.php" enctype="multipart/form-data">
    <input type="file" name = "img_upload" id="img_upload">
    <input type="submit" value="upload" name="upload">
</form>
</div>

<?php include_once 'mosaique.php'; ?>
<script type="text/javascript">

</script>
</body>
</html>