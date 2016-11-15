<?php
	session_start();
	function random($car) {
    $string = "";
    $chaine = "a0bc1de2fg3hi4jk5lm6no7pq8rs9tuvwxyz";
    srand((double)microtime()*1000000);
    for($i=0; $i<$car; $i++) {
        $string .= $chaine[rand()%strlen($chaine)];
    }
    return $string;
   }

   if (isset($_POST['forgive']) && isset($_POST['mail']) && $_SESSION['rank'] !== 1 )
   {
   		$sel = random(20);
   		include_once '../config/logDB.php';
		$mail = $_POST['mail'];
		$tmppw = hash(whirlpool, $sel);
		$req = $dbh->prepare("SELECT * FROM `usr` WHERE mail = :mail");
		$req->bindValue('mail', $_POST['mail'], PDO::PARAM_STR);
		$req->setFetchMode(PDO::FETCH_OBJ);
		$req->execute();
		$results = $req->fetch();
		if ($req->rowCount() === 0)
		{
			header("refresh:2;url=inscription.php");
			echo "Adresse mail introuvable.";
			exit ();
		}
		else
		{
			$login = $results->login;
			$req = $dbh->prepare("UPDATE `usr` SET `passwd` = :passwd WHERE mail = :mail");
			$req->bindValue('mail', $_POST['mail'], PDO::PARAM_STR);
			$req->bindValue('passwd', $tmppw, PDO::PARAM_STR);
			$req->setFetchMode(PDO::FETCH_OBJ);
			$req->execute();
			header('refresh:3;url=connexion.php');
			echo "Le mot de passe a été modifié. Vous avez recu un mail de reinitialisation";
			$destinataire = $_POST['mail'];
			$sujet = "Réinitialisation mot de passe CAMAGRU";
			$message = "Bonjour ".$login." \n Voici votre mot de passe temporaire: \n".$sel."\n Vous pouvez vous connecter et vous êtes invité à le modifier immédiatement. ";
			$entete = "From: forgivepassword@camagru.fr";
			mail($destinataire, $sujet, $message, $entete);
		}
	}	
 

include_once('header.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Formulaire mdp oublié</title>
</head>
<body>
<form action="forgivepwd.php" method="post">
Entrez votre email pour recevoir un mot de passe temporaire: <input type="text" name="mail" value="" placeholder="email"/> <br/>
<input type="submit" name="forgive" value="OK">
</form>

<?php include 'footer.php';?>
</body>
</html>
