<?php
session_start();
if ($_POST[login] != "" && $_POST[password] != "")
{
	$url = '../index.php';
	$_SESSION[loggued] = $_POST[login];
}
else
{
	$url = '../connexion.php';
	$_SESSION[loggued] = "";
}
header('Location: ' . $url);
?>