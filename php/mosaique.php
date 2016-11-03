<?php
	if (!isset($_SESSION))
		session_start();
	include_once '../config/logDB.php';
	include_once 'functions.php';
	
	// initialisation pagination
	$ppp = 9; // pictures per pages
	$req = $dbh->prepare("SELECT COUNT(*) AS total FROM img;");
	$req->setFetchMode(PDO::FETCH_OBJ);
	$req->execute();
	$results=$req->fetch();
	$total = $results->total; //total img
	$nbpages = ceil($total/$ppp);
	if (isset($_GET['page']))
	{
		$page = intval($_GET['page']);
		if ($page > $nbpages)
			$page = $nbpages;
	}
	else
	{
		$page = 1;
	}
	$firstimg = $ppp * ($page - 1);
	$tmp = $firstimg + $ppp;
	echo $firstimg, 'et', $tmp;
	//request all images
	$req = $dbh->prepare("SELECT * FROM img ORDER BY date_img DESC LIMIT :firstimg, :lastimg;");
	$req->bindValue('firstimg', $firstimg, PDO::PARAM_INT);
	$req->bindValue('lastimg', $firstimg + $ppp, PDO::PARAM_INT);
	$req->setFetchMode(PDO::FETCH_OBJ);
	$req->execute();
	echo "<div class='glr'>";
	$i = 0;
	while ($results = $req->fetch())
	{
		if ($i % 3 === 0)
		{
			echo "<div class=\"blockInline\">";
		}
		?>
		<div class="contentBlock">
		<?php
		
		$login = get_login($results->id_usr);
		$likes = get_like($results->id_img);
		$islike = is_like($results->id_img, $results->id_usr);
		echo "	
				<img class='img_glr' onclick=\"affCom(".$results->id_img.");\" id=img_".$results->id_img." src='",$results->path_img,"'/>
				<div class='desc_glr' id='desc_".$results->id_img."'>",

				//lien image taille reelle
				"<div class=\"buttonContent\"><a href=",$results->path_img,"><button type=\"button\">Taille reelle</button></a>";

				//supprimer image
				if ($results->id_usr === $_SESSION['id_usr'])
				{
					echo "<form action= \"delImg.php\" method=\"post\">",
					"<input type=\"hidden\" id=\"id_img\" name=\"id_img\" value=\"",$results->id_img,"\">",
					"<input type=\"submit\" id=\"delImg\" name=\"delImg\" value=\"Supprimer cette image (DEFINITIF)\">",
					"</form>";
				
				}
				//partie like
				echo "<form action= \"like.php\" method=\"post\">";
				if ($islike === TRUE) // boutton dislike
					echo "<input type=\"submit\" id=\"like\" name=\"like\" value=\"like\">";
				else // button like
					echo "<input type=\"submit\" id=\"dislike\" name=\"dislike\" value=\"dislike\">";
				echo "<input type=\"hidden\" id=\"id_img\" name=\"id_img\" value=\"",$results->id_img,"\">",
	
				
				"</form></div>",

				//affichage commentaire et description
				"<div class='description'>",$results->description,"</div>",
				"<div class='login'>",	$login, "</div>",
				"<div class='date'>",$results->date_img, "</div>", 
				"<div class='likes'>",$likes, " <img id='likeimg' src='../effects/like.png'> </div>",
				
				"<div class='com'>", get_com($results->id_img), "</div>",
				
				//ajout commentaire
				"<form action= \"commentaires.php\" method=\"post\">",
				"<input type=\"text\" id=\"com\" name=\"com\" placeholder=\"entrez votre commentaire\" maxlength=\"255\">",
				"<input type=\"hidden\" id=\"id_img\" name=\"id_img\" value=\"",$results->id_img,"\">",
				"<input type=\"submit\" id=\"addCom\" name=\"addCom\" value=\"Poster\">",
				"</form>",


				"</div>"

				;
		?>
		</div>
		<?php
		if ($i % 3 === 2)
		{
			echo "</div>";
		}
		$i++;
	}
	echo "</div><div class=\"pageChange\">Page ";
	for ($i=1; $i<=$nbpages; $i++)
	{
		if ($i === $page)
			echo '('.$i.')';
		else
			echo '<a href="galerie.php?page='.$i.'">'.$i.'</a> ';
	}
	echo "</div>";
	
?>

<script type="text/javascript" src="../js/galerie.js"></script>