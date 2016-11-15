<?php
	if (!isset($_SESSION))
		session_start();
	if ($_SESSION['rank'] !== 1)
	{
		header ('Location: accueil.php');
		exit();
	}
	header('content-type: image/png');
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
	// else if (isset($_POST['img']))
	// {
	// 	$img = $_POST['img'];//(isset($_POST["img"])) ? htmlentities($_POST["img"]) : NULL;
 //    	$img = str_replace('data:image/png;base64,', '', $img);
	// 	$img = str_replace(' ', '+', $img);
	// 	$data = base64_decode($img);
	// 	$im = imagecreatefromstring($data);
	// 	header("content-type: image/png");
	// //	print $_POST['img'];
 //    	//file_put_contents('tmp/tmp1.png', $data);
	// 	move_uploaded_file($_POST['img'], '../tmp/tmp1.png');

	// 	imagepng($im, $filename);
 // 	}

 	else if (isset($_POST['img']) && $_POST['img'] != "") {
	 	echo "snapshot";
		// get the content of the captured image from the webcam put it in a tmp img
		list($type, $data) = explode(';', $_POST['img']);
		list(, $data) = explode(',', $data);
		$data = base64_decode($data);
		echo $data;
		file_put_contents( '../tmp/tmp1.png', $data);
		// creat image from this temporary 
		$im = imagecreatefrompng($data);
		// get selected alpha
		$alpha = imagecreatefrompng('../effects/griffes.png');
			
		imagecopymerge_alpha($im, $alpha, 0, 0, 0, 0, imagesx($alpha), imagesy($alpha), 100);
		// Create file name and register the image in database
		imagepng($im, $filename);
		// free memory
		imagedestroy($im);
		//die();
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
	header ('Content-Type: image/png');
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