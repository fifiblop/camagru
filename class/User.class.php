<?php
require __DIR__ . "/../autoload.php";

abstract class User {

	static function createUser($email, $login, $password) {
		$db = new Database();
		$create = $db->query("USE db_camagru");
		$create->execute();
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
		$create = $db->query("USE db_camagru");
		$create->execute();
		$create = $db->query("UPDATE user SET active = 1 WHERE hash = :hash;");
		$create = $db->bind(":hash", $hash);
		$create->execute();
	}

	static function changePassword($password, $hash) {
		$db = new Database();
		$create = $db->query("USE db_camagru");
		$create->execute();
		$create = $db->query("UPDATE user SET password = :password WHERE hash = :hash;");
		$create = $db->bind(":password", hash("whirlpool", $password));
		$create = $db->bind(":hash", $hash);
		$create->execute();
	}

	static function isActive($login) {
		$db = new Database();
		$create = $db->query("USE db_camagru");
		$create->execute();
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
		$create = $db->query("USE db_camagru");
		$create->execute();
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
		$create = $db->query("USE db_camagru");
		$create->execute();
		$create = $db->query("SELECT email FROM user WHERE email = :email;");
		$create = $db->bind(":email", $email);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return true;
	}

	static function getLoginByEmail($email) {
		$db = new Database();
		$create = $db->query("USE db_camagru");
		$create->execute();
		$create = $db->query("SELECT login FROM user WHERE email = :email;");
		$create = $db->bind(":email", $email);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return $create->fetch()[0];
	}

	static function getLoginByHash($hash) {
		$db = new Database();
		$create = $db->query("USE db_camagru");
		$create->execute();
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
		$create = $db->query("USE db_camagru");
		$create->execute();
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
		$create = $db->query("USE db_camagru");
		$create->execute();
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
		$create = $db->query("USE db_camagru");
		$create->execute();
		$create = $db->query("SELECT hash FROM user WHERE email = :email;");
		$create = $db->bind(":email", $email);
		$create->execute();
		$count = $create->rowCount();
		if ($count < 1)
			return false;
		return $create->fetch()[0];
	}
}