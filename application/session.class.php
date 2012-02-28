<?php

class Session {

	/**
	 *
	 * Application user identification
	 * @var integer
	 */
	public static $UserID;

	public static $UserName;

	public static $session_timeout = 3600; // miliseconds

	public static function Start() {

		session_start();

		if(isset($_SESSION['last_activity'])) {
			if(time() - $_SESSION['last_activity'] > Session::$session_timeout) { // session timeout!
				Session::destroySession();
				session_start(); // to update $_SESSION vars
			}
			else
				$_SESSION['last_activity'] = time();
		}

		Session::initVars();

	}

	public static function isAuthenticated() {
		return isset($_SESSION['USER_ID']);
	}

	public static function authenticateUser($id) {
		$_SESSION['USER_ID'] = $id;
		Session::initVars();
	}

	public static function destroySession() {
		session_destroy();
	}
	/**
	 * PRIVATE
	 */
	public static function initVars() {
		if(isset($_SESSION['USER_ID'])) {
			Session::$UserID = $_SESSION['USER_ID'];
			$db = DB::getInstance();
			$stmt = $db->prepare("SELECT email FROM users WHERE ID=:id");
			$stmt->bindParam(':id', Session::$UserID, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch();
			Session::$UserName = $result[0];
			//
			$_SESSION['last_activity'] = time();
		}
		else
			Session::$UserID = -1;
	}
}