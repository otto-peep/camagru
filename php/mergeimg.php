<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1)
	{
		header ('Location: accueil.php');
		exit();
	}
//	header("content-type: image/png");
	echo "This is mergeimg";
	print_r($_FILES);
	echo "<br/>";
	print_r ($_POST);

	//readfile($_FILES['fileToUpload']['tmp_name']);
	
	if (isset($_POST['fileToUpload']))
	{
		$img = (isset($_POST['fileToUpload'])) ? htmlentities($_POST['fileToUpload']) : NULL;
	    $img = preg_replace('/\s/', '+', $img);
	    list($type, $data) = explode(';', $img);
	    list(, $data) = explode(',', $data);
	    $data = base64_decode($data);
	    file_put_contents('../tmp/tmp1.png', $data);
	}
	else
	{
		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "../tmp/tmp1.png");
	}
	$im = imagecreatefrompng('../tmp/tmp1.png');
	header('Content-Type: image/png');
	imagepng($im);
	$filter = imagecreatefrompng('../effects/griffes.png');
	imagecopymerge($im, $filter, 0, 0, 0, 0, imagesx($filter), imagesy($filter), 50);
	$imagepng($im, '../img/montage.png');
	$imagedestroy($im);
	$imagedestroy($filter);
?>