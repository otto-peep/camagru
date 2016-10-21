<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1)
	{
		header("refresh:5;url=connexion.php");
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
    <video autoplay="true" id="webcam">
    </video>
    <input type="button" id="capture" value="Prendre une photo" onclick="TakePicture();">
</div>
<canvas id="canvas">

</canvas>
<input type="button" id="save" value="Sauvegarder la photo" onclick="SavePicture();">
<script type="text/javascript">
	var video = document.querySelector("#webcam");
 
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;
 
if (navigator.getUserMedia) {       
    navigator.getUserMedia({video: true}, DisplayVideo, ErrorVideo);
}
 
function DisplayVideo(stream) {
    video.src = window.URL.createObjectURL(stream);
}
 
function ErrorVideo(e) {
	console.log("Error :" + e);

}
function TakePicture (){
	var canvas = document.querySelector('canvas');
	var image = document.querySelector('picture');
	width = video.videoWidth;
	height = video.videoHeight;
	context = canvas.getContext('2d');
	canvas.width = width;
	canvas.height = height;
	context.drawImage(video, 0, 0, width, height);
	var imageDataURL = canvas.toDataURL('image/png');
	image.setAttribute('src', imageDataURL);
}
function SavePicture(){
}
</script>
</body>
</html>