<?php 
	require __DIR__ . "/../autoload.php";
	session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Camagru</title>
	<link rel="icon" type="image/gif" href="/camagru/ressources/favicon.ico" sizes="16x16"/>
	<link rel="stylesheet" type="text/css" href="/camagru/style.css">
</head>
<body>
<header>
	<div class="nav">
		<ol>
			<div class="link-left">
				<li><a id="logo" href="/camagru/index.php">CAMAGRU</a></li>
			</div>
			<div class="link-right">
			<!-- <?php if ($_SESSION[loggued] == "") { ?> -->
				<li><a href="/camagru/views/inscription.php">S'INSCRIRE</a></li>
				<li><label>|</label></li>
				<li><a href="/camagru/views/connexion.php">SE CONNECTER</a></li>
			 <!-- <?php } else { ?>
				<li><?= strtoupper($_SESSION[loggued]) ?></li>
				<li><label>|</label></li>
				<li><a href="/camagru/views/camagru.php">CRÉER</a></li>
				<li><label>|</label></li>
				<li><a href="#">DÉCONNEXION</a></li>
			 <?php } ?> -->
			</div>
		</ol>
	</div>
	
</header>
<!-- <div class="header-error">
	<?= $_SESSION[loggued] ?>
</div> -->