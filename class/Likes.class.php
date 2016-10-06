<?php 

abstract class Likes {
	
	static function likeImage($id_image, $id_user) {
		$db = new Database();
		$create = $db->query("INSERT INTO likes (id_image, id_user) VALUES (:id_image, :id_user)");
		$create = $db->bind(":id_image", $id_image);
		$create = $db->bind(":id_user", $id_user);
		$create->execute();
	}
	
	static function unlikeImage($id_image, $id_user) {
		$db = new Database();
		$create = $db->query("DELETE FROM likes WHERE id_image = :id_image AND id_user = :id_user");
		$create = $db->bind(":id_image", $id_image);
		$create = $db->bind(":id_user", $id_user);
		$create->execute();
	}
	
	static function userlike($id_image, $id_user) {
		$db = new Database();
		$create = $db->query("SELECT * FROM likes WHERE id_image = :id_image AND id_user = :id_user");
		$create = $db->bind(":id_image", $id_image);
		$create = $db->bind(":id_user", $id_user);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return true;
	}
    
	static function getNbLikesByIdPhoto($id_image) {
		$db = new Database();
		$create = $db->query("SELECT count(*) FROM likes WHERE id_image = :id_image");
		$create = $db->bind(":id_image", $id_image);
		$create->execute();
		if ($create->rowCount() == 0)
			return false;
		return $create->fetch()[0];		
	}
	
	static function deleteLikesById($id_image) {
		$db = new Database();
		$create = $db->query("DELETE FROM likes WHERE id_image = :id_image");
		$create = $db->bind(":id_image", $id_image);
		$create->execute();
	}
}