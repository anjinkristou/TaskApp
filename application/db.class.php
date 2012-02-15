<?php

class DB {

	private static $instance = NULL;

	public static function getInstance() {
		if(!self::$instance) {
			self::$instance = new PDO("mysql:host=localhost;dbname=taskapp", "taskapp", "taskapp");
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		return self::$instance;
	}

	/**
	 *
	 * In case someone want to create instance or clone this object
	 */
	private function __construct() {}
	private function __clone() {}

}


