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
	
	if (isset($_FILES['fileToUpload']))
	{
		$img = (isset($_FILES["fileToUpload"]["tmp_name"])) ? htmlentities($_FILES["fileToUpload"]["tmp_name"]) : NULL;
	    $img = preg_replace('/\s/', '+', $img);
	    list($type, $data) = explode(';', $img);
	    list(, $data) = explode(',', $data);
	    $data = base64_decode($data);
	    file_put_contents('../tmp/tmp1.png', $_FILES["fileToUpload"]["tmp_name"]);
	}
	else if (isset($_POST['fileToUpload']))
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
		echo "ERROR NO FILES";
		exit ();
	}
	$im = imagecreatefrompng('../tmp/tmp1.png');
	//if ($_POST['filter'] === 'griffes')
		$filter = imagecreatefrompng('../effects/troll.png');
	//else
	//	echo "NO FILTER SELECTED";
	imagecopyresampled($im, $filter, 300, 225, 0, 0, imagesx($filter), imagesy($filter), imagesx($filter), imagesy($filter));  
	ob_start();
	imagepng($im);
	$data = ob_get_clean();
	$filename = '../img/'.$_SESSION['login'].date("m.d.y.H.i.s").".png";
	include '../config/logDB.php';
	$req = $dbh->prepare("INSERT INTO `img` (`id_img`, `path_img`, `id_usr`, `date_img`, `description`) VALUES (NULL, :path_img, :id_usr, NOW(), :description)");
	$req->bindValue('path_img', $filename, PDO::PARAM_STR);
	$req->bindValue('description', "description", PDO::PARAM_STR);
	$req->bindValue('id_usr', $_SESSION['id_usr'], PDO::PARAM_STR);
	$req->setFetchMode(PDO::FETCH_OBJ);
	$req->execute();
	file_put_contents($filename, $data);
	imagedestroy($im);
	imagedestroy($filter);
?>