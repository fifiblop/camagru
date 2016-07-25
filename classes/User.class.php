<?php
require_once '../config/database.php';

class User {

	public function create_user($login, $email, $password) {
		$bdd = database_connect();
		$sql = "INSERT INTO user (login, email, password)
		VALUES (:login, :email, :password);";
		$stmt = $bdd->prepare($sql);
		$stmt->bindParam(':login', $login, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':password', $password, PDO::PARAM_STR);
		$stmt->execute();
	}

	public function user_exists($login) {
		$bdd = database_connect();
		$sql = "SELECT id FROM user WHERE login = :login;";
		$stmt = $bdd->prepare($sql);
		$stmt->bindParam(':login', $login, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		if ($count == 1)
			return (true);
		return (false);
	}
};

// $fifi = new User("fifi", "fifi@gmail.com", "yupp");
$polo = new User();
// $polo->create_user("polo", "polo@gmail.com", "polo");
if ($polo->user_exists("polo"))
	echo "yes";
else
	echo "no";

?>