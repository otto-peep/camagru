<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1)
	{
		header ('Location: accueil.php');
		exit();
	}
	if ($_FILES['fileToUpload']['error']){
		header("refresh:1;url=montage.php");
		echo 'Erreur dans l\'upload du fichier';
		exit ();
	}
	if ($_FILES['fileToUpload']['size'] > 400000){
		header("refresh:1;url=montage.php");
		echo 'Le fichier est trop volumineux';
		exit ();
	}
	else if ($_FILES['fileToUpload']['type'] != 'image/png'){
		header("refresh:1;url=montage.php");
		echo 'Vous devez uploader un fichier au format png';
		exit();
	}
	$b64 = base64_encode(file_get_contents($_FILES['fileToUpload']['tmp_name']));
	$img = imagecreatefromstring(base64_decode($b64));
	if ($img == false){
		header("refresh:1;url=montage.php");
		echo 'La creation de l\'image a echouee ce n\'est pas une image';
		exit ();
	}
	if ($_POST['filter'] == 'griffes')
		$filter = imagecreatefrompng('../effects/griffes.png');
	else if ($_POST['filter'] == 'troll')
		$filter = imagecreatefrompng('../effects/troll.png');
	else if ($_POST['filter'] == 'thumbup')
		$filter = imagecreatefrompng('../effects/like.png');
	else{
		header("refresh:1;url=montage.php");
		echo 'Vous devez choisir un filtre';
		exit();
	}
	$target_dir = "../img/";
	$target_file = $target_dir . $_SESSION['login'].date("m.d.y.H.i.s").".png";
	imageAlphaBlending($filter, true);
	imageSaveAlpha($filter, true);
	imagecopy($img, $filter, 0, 0, 0, 0, imagesx($filter), imagesy($filter));
	imagepng($img, $target_file);
	
	ob_start();
	imagepng($img);
	ob_end_clean();
	imagedestroy($img);
	imagedestroy($filter);
	include '../config/logDB.php';
	$description = htmlspecialchars($_POST['description']);
	if (strlen($description) > 200){
		header("refresh:1;url=montage.php");
		echo 'La description doit faire moins de 200 caracteres';
		exit();
	}
	header ('Location: montage.php');
	$req = $dbh->prepare("INSERT INTO `img` (`id_img`, `path_img`, `id_usr`, `date_img`, `description`) VALUES (NULL, :path_img, :id_usr, NOW(), :description)");
	$req->bindValue('path_img', $target_file, PDO::PARAM_STR);
	$req->bindValue('description', $description, PDO::PARAM_STR);
	$req->bindValue('id_usr', $_SESSION['id_usr'], PDO::PARAM_STR);
	$req->setFetchMode(PDO::FETCH_OBJ);
	$req->execute();
?>