<?php 
	require __DIR__ . "/../autoload.php";
	session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="/style.css">
	<link rel="stylesheet" href="/ressources/font-awesome-4.6.3/css/font-awesome.min.css">
</head>
<body>
<header>
	<div class="nav">
		<ol>
			<div class="link-left">
				<li><a id="logo" href="/">CAMAGRU</a></li>
			</div>
			<div class="link-right">
			<?php if ($_SESSION[loggued] == "") { ?>
				<li><a href="/views/inscription.php">S'INSCRIRE</a></li>
				<li><label>|</label></li>
				<li><a href="/views/connexion.php">SE CONNECTER</a></li>
			 <?php } else { ?>
				<li><a href="/views/home.php"><i class="fa fa-user" aria-hidden="true"></i> <?= strtoupper($_SESSION[loggued]) ?></a></li>
				<li><label>|</label></li>
				<li><a href="/views/camagru.php">MONTAGE</a></li>
				<li><label>|</label></li>
				<li><a href="/actions/logout.php">DÉCONNEXION</a></li>
			 <?php } ?>
			</div>
		</ol>
	</div>
	
</header>
<!-- <div class="header-error">
	<?= $_SESSION[loggued] ?>
</div> -->