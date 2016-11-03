<?php
	function get_login($id_usr)
	{
		include '../config/logDB.php';
		$log = $dbh->prepare("SELECT login FROM usr WHERE id_usr = :id_usr;");
		$log->bindValue('id_usr', $id_usr, PDO::PARAM_INT);
		$log->setFetchMode(PDO::FETCH_OBJ);
		$log->execute();
		$results = $log->fetch();
		return ($results->login);
	}

	function get_com($img_id)
	{
		include '../config/logDB.php';
		$log = $dbh->prepare("SELECT * FROM com WHERE id_img = :id_img ORDER BY date_com ASC;");
		$log->bindValue('id_img', $img_id, PDO::PARAM_INT);
		$log->setFetchMode(PDO::FETCH_OBJ);
		$log->execute();
		// requete qui affiche chaque commentaire pour une image
		while($results = $log->fetch())
		{
			//boutton supprimer commentaire
			if ($_SESSION['id_usr'] === $results->id_usr)
			 {
			 	echo "<form action= \"delCom.php\" method=\"post\">",
			 	"<input type=\"hidden\" id=\"id_img\" name=\"id_img\" value=\"",$results->id_img,"\">",
			 	"<input type=\"hidden\" id=\"id_com\" name=\"id_com\" value=\"",$results->id_com,"\">",
			 	"<input type=\"submit\" id=\"delCom\" name=\"delCom\" value=\"del\">",
			 	"</form>";
			}

			//afficher commentaire
			echo "<div class=com>",$results->com."<br/>".get_login($results->id_usr)."<br/>".$results->date_com."<br/><br/></div>";
		}
		return ($com);
	}
	function get_like($img_id)
	{
		include '../config/logDB.php';
		$log = $dbh->prepare("SELECT * FROM likes WHERE id_img = :id_img;");
		$log->bindValue('id_img', $img_id, PDO::PARAM_INT);
		$log->setFetchMode(PDO::FETCH_OBJ);
		$log->execute();
		$likes = $log->rowCount();
		return ($likes);
	}

	function is_like($id_img, $id_usr)
	{
		include '../config/logDB.php';
		$log = $dbh->prepare("SELECT * FROM likes WHERE id_img = :id_img && id_usr = :id_usr;");
		$log->bindValue('id_img', $id_img, PDO::PARAM_INT);
		$log->bindValue('id_usr', $id_usr, PDO::PARAM_INT);
		$log->setFetchMode(PDO::FETCH_OBJ);
		$log->execute();
		if ($log->rowCount() !== 0)
			return (FALSE);
		else
			return (TRUE);
	}

	function get_mail($id_img)
	{
		include '../config/logDB.php';
		$log = $dbh->prepare("SELECT `usr`.`mail` FROM img INNER JOIN usr WHERE `img`.`id_usr` = `usr`.`id_usr` && `img`.`id_img` = :id_img;");
		$log->bindValue('id_img', $id_img, PDO::PARAM_INT);
		$log->setFetchMode(PDO::FETCH_OBJ);
		$log->execute();
		$results = $log->fetch();
		$mail = $results->mail;
		return ($mail);
	}
?>