<?php
require_once '../classes/User.php';

session_start();
ob_start();

if ($_POST[login] != "" && $_POST[email] != "" && $_POST[password] != "")
{
	create_user($_POST[login], $_POST[email], $_POST[password]);
	$url = '../index.php';
	$_SESSION[loggued] = $_POST[login];
}
else
{
	$url = '../inscription.php';
	$_SESSION[loggued] = "";
}

header('Location: ' . $url);
ob_flush();
?>