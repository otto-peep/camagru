<?php
	if (!isset($_SESSION))
		session_start();
?>
<head>
	<link rel="stylesheet" href="../css/header.css">
</head>
<body>
<div class = "topbox">
<ul class="topnav">
  <li><a href="accueil.php">Accueil</a></li>
  <li><a href="galerie.php">Galerie</a></li>
  	<?php
  	if ($_SESSION['rank'] === 0 || !$_SESSION['rank'])
    {
  		echo  "<li class=\"right\"><a href=\"inscription.php\">Inscription</a></li>";
      echo "<li class=\"right\"><a href=\"connexion.php\">Connexion</a></li>";
    }
  	if ($_SESSION['rank'] === 1)
  	{
  		echo "<li class=\"right\"><a href=\"compte.php\">Compte</a></li>";
      echo "<li class =\"right\"><a href=\"deconnexion.php\">Deconnexion</a></li>";
	   }
	?>
</ul>


</div>
</body>
</html>

