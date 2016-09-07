<?php
	
session_start();
$_SESSION[loggued] = "";
header("Location: ../index.php");