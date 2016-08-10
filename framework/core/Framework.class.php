<?php

class Framework {

	public static function run() {
		self::init();
		self::autoload();
		self::dispatch();
	}

	// Initialisation 
	private static function init(){
		// define path constants

		define("DS", DIRECTORY_SEPARATOR);
		define("ROOT", getcwd() . DS);
		define("APP_PATH", ROOT . 'application' . DS);
		define("FRAMEWORK_PATH", ROOT . 'framework' . DS);
		define("PUBLIC_PATH", ROOT . "public" . DS);

		define("CONFIG_PATH", APP_PATH . "config" . DS);
		define("CONTROLLER_PATH", APP_PATH . "controllers" . DS);
		define("MODEL_PATH", APP_PATH . "models" . DS);
		define("VIEW_PATH", APP_PATH . "views" . DS);

		define("CORE_PATH" . FRAMEWORK_PATH . "core" . DS);
		define("DB_PATH" . FRAMEWORK_PATH . "database" . DS);
		define("LIB_PATH" . FRAMEWORK_PATH . "libraries" . DS);
		define("HELPER_PATH" . FRAMEWORK_PATH . "helpers" . DS);
		define("UPLOAD_PATH" . PUBLIC_PATH . "uploads" . DS);


	}

	private function autoload() {

	}

	private function dispatch() {

	}
}