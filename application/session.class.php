<?php

class Session {

	public static $ID;
	public static $Status;
	public static $User;
	public static $UserID;

	private static $isAuthenticated;

	public static function Start() {
		session_start();
		Session::$ID = session_id();
	}

	public static function isAuthenticated() {
		if(isset($_SESSION['ID_USER']))
			return true;
		else
			return false;
	}

	public static function authenticateUser($id) {
		$_SESSION['ID_USER'] = $id;
	}

	public static function destroySession() {
		session_destroy();
	}

}