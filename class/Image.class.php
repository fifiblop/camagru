<?php

abstract class Image {
	static function merge($src, $sticker, $result, $stick_xpos, $stick_ypos) {
		list($width_x, $height_x) = getimagesize($src);
		list($width_y, $height_y) = getimagesize($sticker);

		$image = imagecreatetruecolor($width_x, $height_x);

		$image_x = imagecreatefrompng($src);
		$image_y = imagecreatefrompng($sticker);


		imagecopy($image, $image_x, 0, 0, 0, 0, $width_x, $height_x);
		imagecopyresized($image, $image_y, $stick_xpos, $stick_ypos, 0, 0, $width_y / 3, $height_y / 3, $width_y, $height_y);

		imagejpeg($image, $result);
		imagedestroy($image);
		imagedestroy($image_x);
		imagedestroy($image_y);
	}
}