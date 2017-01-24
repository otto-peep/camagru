<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1)
	{
		header ('Location: accueil.php');
		exit();
	}

	if (!$_POST['image64']){
		echo json_encode('Vous devez envoyer une image');
		exit();
	}
	//select right filter
	if ($_POST['filter'] == 'griffes')
		$filter = imagecreatefrompng('../effects/griffes.png');
	else if ($_POST['filter'] == 'troll')
		$filter = imagecreatefrompng('../effects/troll.png');
	else if ($_POST['filter'] == 'thumbup')
		$filter = imagecreatefrompng('../effects/like.png');
	else{
		echo json_encode('Vous devez choisir un filtre');
		exit();
	}
	$decodeImg = base64_decode($_POST['image64']);
	$img = imagecreatefromstring($decodeImg);
	if ($img == false){
		echo json_encode('Erreur lors de la creation de l\'image');
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
	
	// insertion dans la db
	include '../config/logDB.php';
	$description = htmlspecialchars($_POST['description']);
	if (strlen($description) > 200){
		echo json_encode('La description doit faire moins de 200 caracteres');
		exit();
	}
	$req = $dbh->prepare("INSERT INTO `img` (`id_img`, `path_img`, `id_usr`, `date_img`, `description`) VALUES (NULL, :path_img, :id_usr, NOW(), :description)");
	$req->bindValue('path_img', $target_file, PDO::PARAM_STR);
	$req->bindValue('description', $description, PDO::PARAM_STR);
	$req->bindValue('id_usr', $_SESSION['id_usr'], PDO::PARAM_STR);
	$req->setFetchMode(PDO::FETCH_OBJ);
	$req->execute();
	echo json_encode('ok');
	exit();
?>