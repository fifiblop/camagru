<?php

	$dsn = "mysql:host=localhost;port=8080";
	$user = "root";
	$password = "root";

	// Connexion a la base

	try {
		$db = new PDO($dsn, $user, $password);
		$db->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::CASE_NATURAL);
		print("connection successful" . PHP_EOL);
	} catch (PDOException $e) {
		print("error: " . $e->getMessage() . PHP_EOL);
	}

	// Creation de la base de donnée

	try {
		$create = $db->query("CREATE DATABASE IF NOT EXISTS db_camagru");
		$create->execute();
		print("DATABASE db_camagru created" . PHP_EOL);
	} catch (PDOException $e) {
		print("error: " . $e->getMessage() . PHP_EOL);
	}

	// Selection de la base camagru

	$create = $db->query("USE db_camagru");
	$create->execute();

	// Creation de la table user

	try {
		$sql = "CREATE TABLE IF NOT EXISTS user (
		id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		login VARCHAR(255) NOT NULL,
		email VARCHAR(255) NOT NULL,
		password VARCHAR(255) NOT NULL,
		hash VARCHAR(255) NOT NULL,
		active BOOLEAN DEFAULT 0);";
		$create = $db->query($sql);
		$create->execute();
		print("TABLE user created" . PHP_EOL);
	} catch (PDOException $e) {
		print("error: " . $e->getMessage() . PHP_EOL);
	}
?>