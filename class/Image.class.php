<?php

abstract class Image {
	
	static function uploadImage($id_user, $src) {
		date_default_timezone_set("Europe/Paris");
		$db = new Database();
		$create = $db->query("INSERT INTO image (id_user, src, date) VALUES(:id_user, :src, :date)");
		$create = $db->bind(":id_user", $id_user);
		$create = $db->bind(":src", $src);
		$create = $db->bind(":date", date("Y-m-d H:i:s", time()));
		$create->execute();
	}
	
	static function getAllImages() {
		$db = new Database();
		$create = $db->query("SELECT * FROM image ORDER BY id DESC");
		$create->execute();
		if ($create->rowCount() < 1)
			return false;
		$array = $create->fetchAll(PDO::FETCH_ASSOC);
		return $array;
	}
	
	static function imageExist($id) {
		$db = new Database();
		$create = $db->query("SELECT * FROM image WHERE id = :id;");
		$create = $db->bind(":id", $id);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return true;
	}
	
	static function getImageById($id) {
		$db = new Database();
		$create = $db->query("SELECT * FROM image WHERE id = :id");
		$create = $db->bind(':id', $id);
		$create->execute();
		if ($create->rowCount() < 1)
			return false;
		$array = $create->fetchAll(PDO::FETCH_ASSOC);
		return $array;		
	}
	
	static function getImagesByUser($id_user) {
		$db = new Database();
		$create = $db->query("SELECT * FROM image WHERE id_user = :id_user ORDER BY id DESC");
		$create = $db->bind(':id_user', $id_user);
		$create->execute();
		if ($create->rowCount() < 1)
			return false;
		$array = $create->fetchAll(PDO::FETCH_ASSOC);
		return $array;
	}
	
	static function getLimitImages($firstImage, $nbImages) {
		$db = new Database();
		$create = $db->query("SELECT * FROM image ORDER BY id DESC LIMIT :firstImage, :nbImages");
		$create = $db->bind(':firstImage', $firstImage);
		$create = $db->bind(':nbImages', $nbImages);
		$create->execute();
		if ($create->rowCount() < 1)
			return false;
		$array = $create->fetchAll(PDO::FETCH_ASSOC);
		return $array;
	}
	
	static function getUserByImageId($id) {
		$db = new Database();
		$create = $db->query("SELECT id_user FROM image WHERE id = :id");
		$create = $db->bind(":id", $id);
		$create->execute();
		if ($create->rowCount() == 0)
			return false;
		return $create->fetch()[0];
	}
	
	static function getNumImageByUser($id_user) {
		$db = new Database();
		$create = $db->query("SELECT count(id) FROM image WHERE id_user = :id_user");
		$create = $db->bind(':id_user', $id_user);
		$create->execute();
		return $create->fetch()[0] + 1;
	}
	
	static function deleteImageById($id) {
		$db = new Database();
		$create = $db->query("DELETE FROM image WHERE id = :id");
		$create = $db->bind(':id', $id);
		$create->execute();
	}
	
	static function merge($src, $sticker, $output, $stick_xpos, $stick_ypos, $stick_w, $stick_h) {
		if (strstr($src, "png"))
			$src = str_replace('data:image/png;base64,', '', $src);
		else
			$src = str_replace('data:image/jpeg;base64,', '', $src);
		$src = str_replace(' ', '+', $src);
		$src = base64_decode($src);
		$src = imagecreatefromstring($src);
		
		$filter = imagecreatefrompng($sticker);
		list($width_y, $height_y) = getimagesize($sticker);
		imagecopyresampled($src, $filter, $stick_xpos, $stick_ypos, 0, 0, $stick_w, $stick_h, $width_y, $height_y);
		
		imagejpeg($src, $output);
	}

}