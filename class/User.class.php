<?php
require __DIR__ . "/../autoload.php";

class User {
	
	private $id = NULL;
	private $login = NULL;
	private $email = NULL;
	private $active = NULL;
	private $hash = NULL;
	
	function __construct($login) {
		$db = new Database();
		$create = $db->query("SELECT id, email, active, hash FROM user WHERE login = :login");
		$create = $db->bind(':login', $login);
		$create->execute();
		if ($create->rowCount() < 1)
			return NULL;
		$array = $create->fetch(PDO::FETCH_ASSOC);
		$this->id = $array['id'];
		$this->login =	$login;
		$this->email = $array['email'];
		$this->active = $array['active'];
		$this->hash = $array['hash'];
	}
	
	function getId() {
		return $this->id;
	}
	
	function getLogin() {
		return $this->login;
	}
	
	function getHash() {
		return $this->hash;
	}
	
	function getEmail() {
		return $this->email;
	}
	
	function getActif() {
		return $this->active;
	}
	
	function __toString() {
		$str = 'id : ' . $this->id . PHP_EOL
		. 'utilisateur : ' . $this->login . PHP_EOL
		. 'email : ' . $this->email . PHP_EOL
		. 'actif : ' . $this->active . PHP_EOL;
		return (string)$str;
	}

	static function createUser($email, $login, $password) {
		$db = new Database();
		$hash = hash("whirlpool", rand(1, 1000) . $login);
		$create = $db->query("INSERT INTO user (email, login, password, hash) VALUES(:email, :login, :password, :hash);");
		$create = $db->bind(":email", $email);
		$create = $db->bind(":login", $login);
		$create = $db->bind(":password", hash("whirlpool", $password));
		$create = $db->bind(":hash", $hash);
		$create->execute();
		return $hash;
	}

	static function activateUser($hash) {
		$db = new Database();
		$create = $db->query("UPDATE user SET active = 1 WHERE hash = :hash;");
		$create = $db->bind(":hash", $hash);
		$create->execute();
	}
	
	static function changeEmail($email, $hash) {
		$db = new Database();
		$create = $db->query("UPDATE user SET email = :email WHERE hash = :hash;");
		$create = $db->bind(":email", $email);
		$create = $db->bind(":hash", $hash);
		$create->execute();
	}

	static function changePassword($password, $hash) {
		$db = new Database();
		$create = $db->query("UPDATE user SET password = :password WHERE hash = :hash;");
		$create = $db->bind(":password", hash("whirlpool", $password));
		$create = $db->bind(":hash", $hash);
		$create->execute();
	}

	static function isActive($login) {
		$db = new Database();
		$create = $db->query("SELECT active FROM user WHERE login = :login;");
		$create = $db->bind(":login", $login);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return $create->fetch()[0];
	}

	static function loginExist($login) {
		$db = new Database();
		$create = $db->query("SELECT login FROM user WHERE login = :login;");
		$create = $db->bind(":login", $login);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return true;
	}

	static function emailExist($email) {
		$db = new Database();
		$create = $db->query("SELECT * FROM user WHERE email = :email;");
		$create = $db->bind(":email", $email);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return true;
	}

	static function getLoginByEmail($email) {
		$db = new Database();
		$create = $db->query("SELECT login FROM user WHERE email = :email;");
		$create = $db->bind(":email", $email);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return $create->fetch()[0];
	}
	
	static function getLoginById($id) {
		$db = new Database();
		$create = $db->query("SELECT login FROM user WHERE id = :id;");
		$create = $db->bind(":id", $id);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return $create->fetch()[0];
	}

	static function getLoginByHash($hash) {
		$db = new Database();
		$create = $db->query("SELECT login FROM user WHERE hash = :hash;");
		$create = $db->bind(":hash", $hash);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return $create->fetch()[0];
	}

	static function getEmailByLogin($login) {
		$db = new Database();
		$create = $db->query("SELECT email FROM user WHERE login = :login;");
		$create = $db->bind(":login", $login);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return $create->fetch()[0];
	}

	static function getPasswordByLogin($login) {
		$db = new Database();
		$create = $db->query("SELECT password FROM user WHERE login = :login;");
		$create = $db->bind(":login", $login);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return $create->fetch()[0];
	}

	static function getHashByEmail($email) {
		$db = new Database();
		$create = $db->query("SELECT hash FROM user WHERE email = :email;");
		$create = $db->bind(":email", $email);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return $create->fetch()[0];
	}
}