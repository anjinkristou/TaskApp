<?php

class Session {

	/**
	 *
	 * Application user identification
	 * @var integer
	 */
	public static $UserID;

	public static $UserName;

	public static function Start() {
		session_start();
		Session::initVars();
	}

	public static function isAuthenticated() {
		if(isset($_SESSION['USER_ID']))
			return true;
		else
			return false;
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
		}
		else
			Session::$UserID = -1;
	}
}