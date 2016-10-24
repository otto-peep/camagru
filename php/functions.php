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
		echo $img_id;
		$log = $dbh->prepare("SELECT * FROM com WHERE id_img = :id_img ORDER BY date_com DESC;");
		$log->bindValue('id_img', $img_id);
		$log->setFetchMode(PDO::FETCH_ASSOC);
		$log->execute();
		while($results = $log->fetch());
		{
			print_r($results);
			$com = $results->com;
			echo $com;
		//	$com = $com."<br/>".$results->com."<br/>".get_login($results->id_usr)."<br/>".$results->date_com."<br/>";
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
?>