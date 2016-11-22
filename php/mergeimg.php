<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1)
	{
		header ('Location: accueil.php');
		exit();
	}
	header ('Location: accueil.php');
	function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){ 
	// function patch for respecting alpha work find on http://php.net/manual/fr/function.imagecopymerge.php
	$cut = imagecreatetruecolor($src_w, $src_h); 
	imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
	imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
	imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
} 

	$filename = '../img/'.$_SESSION['login'].date("m.d.y.H.i.s").".png";
	if ($_FILES['fileToUpload']['name'])
	{
	   move_uploaded_file($_FILES['fileToUpload']['tmp_name'], '../tmp/tmp1.png');
	}
	else
	{
		echo "ERROR NO FILES";
		exit ();
	}

	//create image from tmp file
	if ($_FILES['fileToUpload']['type'] === 'image/jpg')
		$im = imagecreatefromjpg('../tmp/tmp1.png');
	else
		$im = imagecreatefrompng('../tmp/tmp1.png');


	//select right filter
	if ($_POST['filter'] === 'griffes')
		$filter = imagecreatefrompng('../effects/griffes.png');
	else
		echo "NO FILTER SELECTED";

	imagecopymerge_alpha($im, $filter, 0, 0, 0, 0, imagesx($filter), imagesy($filter), 100);
	//imagecopyresampled($im, $filter, 300, 225, 0, 0, imagesx($filter), imagesy($filter), imagesx($filter), imagesy($filter));
	imagepng($im);
	imagepng($im, $filename);
	imagedestroy($im);
	imagedestroy($filter);



	include '../config/logDB.php';
	$req = $dbh->prepare("INSERT INTO `img` (`id_img`, `path_img`, `id_usr`, `date_img`, `description`) VALUES (NULL, :path_img, :id_usr, NOW(), :description)");
	$req->bindValue('path_img', $filename, PDO::PARAM_STR);
	$req->bindValue('description', $_POST['description'], PDO::PARAM_STR);
	$req->bindValue('id_usr', $_SESSION['id_usr'], PDO::PARAM_STR);
	$req->setFetchMode(PDO::FETCH_OBJ);
	$req->execute();

?>