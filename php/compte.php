<?php
	if ($_SESSION['rank'] !== 1)
	{
		header("refresh:2;url=accueil.php");
		echo "Vous n'avez rien à faire ici, vous allez etre redirigé";
		exit ();
	}
	else

?>
<!DOCTYPE html>
<html>
<head>
	<title>Compte</title>
</head>
<body>
	
</body>
</html>