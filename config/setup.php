<?php
	include_once 'database.php';

	$bdd = host_connect();
	$create = $bdd->prepare("CREATE DATABASE IF NOT EXISTS db_camagru");
	$create->execute();

	// Creation de la table user
	
	$bdd = database_connect();
	$sql = "CREATE TABLE IF NOT EXISTS user (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	login VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL);";
	$create = $bdd->prepare($sql);
	$create->execute();
?>