<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Camagru</title>
	<link rel="icon" type="image/gif" href="ressources/favicon.ico" sizes="16x16"/>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
	<div class="nav">
		<ol>
			<li><a id="logo" href="index.php">CAMAGRU</a></li>
			<div class="link">
			<?php if ($_SESSION[loggued] == "") { ?>
				<li><a href="inscription.php">S'INSCRIRE</a></li>
				<li><label>|</label></li>
				<li><a href="connexion.php">SE CONNECTER</a></li>
			<?php } else { ?>
				<li><?= strtoupper($_SESSION[loggued]) ?></li>
				<li><label>|</label></li>
				<li><a href="camagru.php">CRÉER</a></li>
				<li><label>|</label></li>
				<li><a href="src/logout.php">DÉCONNEXION</a></li>
			<?php } ?>
			</div>
		</ol>
	</div>
	
</header>
<!-- <div class="header-error">
	<?= $_SESSION[loggued] ?>
</div> -->