<?php

abstract class Comment {
	
	static function getAllCommentsByIdImage($id_image) {
		$db = new Database();
		$create = $db->query("SELECT * FROM comments WHERE id_image = :id_image ORDER BY id DESC");
		$create = $db->bind(':id_image', $id_image);
		$create->execute();
		if ($create->rowCount() < 1)
			return false;
		$array = $create->fetchAll(PDO::FETCH_ASSOC);
		return $array;	
	}
    
    static function commentImage($text, $id_image, $id_user) {
		$db = new Database();
		$create = $db->query("INSERT INTO comments (id_image, id_user, text, date) VALUES (:id_image, :id_user, :text, :date);");
		$create = $db->bind(":id_image", $id_image);
		$create = $db->bind(":id_user", $id_user);
		$create = $db->bind(":text", $text);
		$create = $db->bind(":date", date("Y-m-d H:i:s", time()));
		$create->execute();
    }
    
    static function getNbCommentByIdPhoto($id_image) {
		$db = new Database();
		$create = $db->query("SELECT count(*) FROM comments WHERE id_image = :id_image");
		$create = $db->bind(":id_image", $id_image);
		$create->execute();
		if ($create->rowCount() == 0)
			return false;
		return $create->fetch()[0];	
    }
    
    static function deleteCommentsById($id_image) {
		$db = new Database();
		$create = $db->query("DELETE FROM comments WHERE id_image = :id_image");
		$create = $db->bind(":id_image", $id_image);
		$create->execute();
    }
}