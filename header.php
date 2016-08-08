<!DOCTYPE html>
<html>
<head>
	<title>Camagru</title>
	<link rel="icon" type="image/gif" href="ressources/favicon.ico" sizes="16x16"/>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
	<nav>
		<a id="logo" href="index.php">CAMAGRU</a>
		<a class="link1" href="connexion.php">SE CONNECTER</a>
		<a class="link2" href="inscription.php">S'INSCRIRE</a>
	</nav>
	
</header>
<div class="error">
	<?= $_SERVER['HTTP_REFERER'] ?>
</div>		
