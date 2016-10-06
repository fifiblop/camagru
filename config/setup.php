<?php

	$dsn = "mysql:host=localhost;port=8080";
	$user = "fifiblop";
	$password = "";

	// Connexion a la base

	try {
		$db = new PDO($dsn, $user, $password);
		$db->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::CASE_NATURAL);
		print("CONNECTION successful" . PHP_EOL);
	} catch (PDOException $e) {
		print("error: " . $e->getMessage() . PHP_EOL);
	}

	// Creation de la base de donnée

	try {
		$db->query("CREATE DATABASE IF NOT EXISTS db_camagru");
		print("DATABASE db_camagru created" . PHP_EOL);
	} catch (PDOException $e) {
		print("error: " . $e->getMessage() . PHP_EOL);
	}

	// Selection de la base camagru

	$db->query("USE db_camagru");

	// Creation de la table user

	try {
		$sql = "CREATE TABLE IF NOT EXISTS user (
		id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		login VARCHAR(255) NOT NULL,
		email VARCHAR(255) NOT NULL,
		password VARCHAR(255) NOT NULL,
		hash VARCHAR(255) NOT NULL,
		active BOOLEAN DEFAULT 0);";
		$db->query($sql);
		print("TABLE user created" . PHP_EOL);
	} catch (PDOException $e) {
		print("error: " . $e->getMessage() . PHP_EOL);
	}
	
	// Creation de la table image

	try {
		$sql = "CREATE TABLE IF NOT EXISTS image (
		id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		id_user INT UNSIGNED NOT NULL,
		FOREIGN KEY(id_user) REFERENCES user(id),
		src VARCHAR(255) NOT NULL,
		date DATE NOT NULL);";
		$db->query($sql);
		print("TABLE image created" . PHP_EOL);
	} catch (PDOException $e) {
		print("error: " . $e->getMessage() . PHP_EOL);
	}

	// Creation de la table likes

	try {
		$sql = "CREATE TABLE IF NOT EXISTS likes (
		id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		id_user INT UNSIGNED NOT NULL,
		FOREIGN KEY(id_user) REFERENCES user(id),
		id_image INT UNSIGNED NOT NULL,
		FOREIGN KEY(id_image) REFERENCES image(id));";
		$db->query($sql);
		print("TABLE likes created" . PHP_EOL);
	} catch (PDOException $e) {
		print("error: " . $e->getMessage() . PHP_EOL);
	}

	// Creation de la table comments

	try {
		$sql = "CREATE TABLE IF NOT EXISTS comments (
		id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		id_user INT UNSIGNED NOT NULL,
		FOREIGN KEY(id_user) REFERENCES user(id),
		id_image INT UNSIGNED NOT NULL,
		FOREIGN KEY(id_image) REFERENCES image(id),
		text VARCHAR(255) NOT NULL,
		date DATE NOT NULL);";
		$db->query($sql);
		print("TABLE comments created" . PHP_EOL);
	} catch (PDOException $e) {
		print("error: " . $e->getMessage() . PHP_EOL);
	}
?>