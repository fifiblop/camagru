<?php
	require __DIR__ . "/../autoload.php";
	session_start();
	
	
	if (isset($_POST[source]) && isset($_POST[sticker_src])){
		define('UPLOAD_DIR', '../gallery/');
		$user = new User($_SESSION[loggued]);
		$src = $_POST[source];
		$sticker = $_POST[sticker_src];
		$filename = $user->getLogin() . "_" . uniqid() . ".jpg";
		$path = UPLOAD_DIR . $user->getLogin();
		if (!is_dir($path))
			mkdir($path);
		$output = $path . "/" . $filename;
		Image::merge($src, $sticker, $output, $_POST[filter_xpos], $_POST[filter_ypos], $_POST[filter_w], $_POST[filter_h]);
		$output = "/camagru/gallery/" . $user->getLogin() . "/" . $filename;
		Image::uploadImage($user->getId(), $output);
		$output = "../gallery/" . $user->getLogin() . "/" . $filename;
		echo $output;
	} else {
		header('Location: ../index.php');
	}