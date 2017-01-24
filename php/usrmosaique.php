<?php
	if (!isset($_SESSION))
		session_start();
	include_once '../config/logDB.php';
	include_once 'functions.php';
	$req = $dbh->prepare("SELECT * FROM img WHERE id_usr = :id_usr ORDER BY date_img DESC;");
	$req->bindValue('id_usr', $_SESSION['id_usr'], PDO::PARAM_STR);
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
		$likes = get_like($results->id_img);
		$islike = is_like($results->id_img, $results->id_usr);
		echo "
				<img class='img_glr' onclick=\"affCom(".$results->id_img.");\" id=img_".$results->id_img." src='",$results->path_img,"'/><br/>
				<div class='desc_glr' id='desc_".$results->id_img."'>",

				//lien image taille reelle
				"<a href=",$results->path_img,"><button type=\"button\">Taille reelle</button></a><br/>";

				//supprimer image
				if ($results->id_usr === $_SESSION['id_usr'])
				{
					echo "<form action= \"delImg.php\" method=\"post\">",
					"<input type=\"hidden\" id=\"id_img\" name=\"id_img\" value=\"",$results->id_img,"\">",
					"<input type=\"submit\" id=\"delImg\" name=\"delImg\" value=\"Supprimer cette image (DEFINITIF)\">",
					"</form>";
				
				}
				echo
				//affichage commentaire et description
				$results->description, "<br/>", $login, "<br/>", $results->date_img, "<br/>", $likes, " likes <br/><br/>",
				
				"<div class='com_glr'>", get_com($results->id_img), "</div></div>";
	}
	echo "</div>";
?>

<script type="text/javascript" src="../js/galerie.js"></script>