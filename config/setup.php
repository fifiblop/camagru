<?php

	include __DIR__ . "/../autoload.php";

	$db = new DATABASE();
	$create = $db->query("CREATE DATABASE IF NOT EXISTS db_camagru");
	$create->execute();

	$create = $db->query("USE db_camagru");
	$create->execute();

	// Creation de la table user

	$sql = "CREATE TABLE IF NOT EXISTS user (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	login VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL);";
	$create = $db->query($sql);
	$create->execute();
?>