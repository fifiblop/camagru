<?php
	require __DIR__ . "/../autoload.php";

	define('UPLOAD_DIR', '../views/');
	$img = $_POST[source];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$name = uniqid();
	$file = UPLOAD_DIR . $name . '.png';
	$output = UPLOAD_DIR . uniqid() . ".jpg";
	file_put_contents($file, $data);
	Image::merge($file , $_POST[sticker_src], $output, $_POST[filter_xpos], $_POST[filter_ypos], $_POST[filter_w], $_POST[filter_h]);
	unlink($file);
	$newimage = $output;
