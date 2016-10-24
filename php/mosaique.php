<?php
	if (!isset($_SESSION))
		session_start();
	
	if ($_SESSION['rank'] !== 1)
	{
		header("refresh:1;url=connexion.php");
		echo "Vous devez d'abord vous connecter. Vous allez etre redirigé";
		exit();
	}
	include_once '../config/logDB.php';
	include_once 'functions.php';
	$req = $dbh->prepare("SELECT * FROM img ORDER BY date_img DESC;");
	$req->setFetchMode(PDO::FETCH_OBJ);
	$req->execute();
	echo "<div class='glr'>";
	while ($results = $req->fetch())
	{
		// $log = $dbh->prepare("SELECT login FROM usr WHERE id_usr = :id_usr;"); //
		// $log->bindValue('id_usr', $results->id_usr, PDO::PARAM_INT);
		// $log->setFetchMode(PDO::FETCH_OBJ);
		// $log->execute();
		// $r = $log->fetch();
		$login = get_login($results->id_usr);
		$com = get_com($results->id_img);
		$likes = get_like($results->id_img);
		echo "
				<img class='img_glr' onclick=\"affCom(".$results->id_img.");\" id=img_".$results->id_img." src='",$results->path_img,"'/><br/>
				<div class='desc_glr' id='desc_".$results->id_img."'>",
				$results->description, "<br/>", $login, "<br/>", $results->date_img, "<br/>", $likes, " likes <br/>",
				"</div><br/>"

				;
	//	print_r($results);
	}
	echo "</div>";
?>

<script type="text/javascript" src="../js/galerie.js"></script>