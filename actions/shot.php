<?php
	require __DIR__ . "/../autoload.php";
	session_start();
	
	define('UPLOAD_DIR', '../gallery/');
	
	$img = $_POST[source];
	if (exif_imagetype($img) == 3)
		$img = str_replace('data:image/png;base64,', '', $img);
	else if (exif_imagetype($img) == 2)
		$img = str_replace('data:image/jpeg;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	
	$user = new User($_SESSION[loggued]);
	$src = UPLOAD_DIR . $user->getLogin();
	if (!is_dir($src))
		mkdir($src);
	$name = $user->getLogin() . "_" . uniqid();
	$file = $src . "/" . uniqid() . '.jpg';
	$output = $src . "/" . $name . ".jpg";
	file_put_contents($file, $data);
	Image::merge($file , $_POST[sticker_src], $output, $_POST[filter_xpos], $_POST[filter_ypos], $_POST[filter_w], $_POST[filter_h]);
	unlink($file);
	Image::uploadImage($user->getId(), $output);
	
	echo $output;