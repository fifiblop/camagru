<?php
	include __DIR__ . "/../autoload.php";
	session_start();

	if (!isset($_GET[hash]) || !isset($_GET[email]))
		header("Location: ../index.php");
	$hash = $_GET[hash];
	$email = $_GET[email];
	if ($hash == User::getHashByEmail($email)) {
		User::activateUser($hash);	
		$_SESSION[loggued] = User::getLoginByEmail($email);
		header("Location: ../index.php");
	}