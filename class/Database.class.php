<?php

include __DIR__ . '/../config/database.php';

define(DB_DSN, $DB_DSN);
define(DB_USER, $DB_USER);
define(DB_PASSWORD, $DB_PASSWORD);

class Database {

	private $dsn = NULL;
	private $user = NULL;
	private $password = NULL;
	private $pdo = NULL;
	private $stmt = NULL;

	public function __construct() {
		$dsn = DB_DSN;
		$user = DB_USER;
		$password = DB_PASSWORD;
		if (is_null($this->pdo)) {
			try {
				$this->pdo = new PDO($dsn, $user, $password);
				$this->pdo->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::CASE_NATURAL);
				// print("connection successful" . PHP_EOL);
			} catch (PDOException $e) {
				print("error: " . $e->getMessage() . PHP_EOL);
			}
		}
	}

	public function query($sql) {
		try {
			$this->stmt = $this->pdo->prepare($sql);
			return $this->stmt;
		} catch (PDOException $e) {
			print("query error: " . $e->getMessage() . PHP_EOL);
		}
	}

	public function bind($param, $value, $type = NULL) {
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
			$this->stmt->bindValue($param, $value, $type);
		}
		if (empty($this->stmt)) {
			return NULL;
		} else {
			return $this->stmt;
		}
	}
}
