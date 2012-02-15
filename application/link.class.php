<?php

class Link {

	public static $controller_var = 'c';
	public static $action_var = 'a';

	public static function ShowAnchor($title, $controller, $action, $attributes = array()) {
		echo Link::MakeAnchor($title, $controller, $action, $attributes);
	}

	public static function MakeURL($controller, $action) {
		if(empty($controller) || empty($action))
			return "";
		$page = Link::getCurrentURL();
		$params = Link::$controller_var . '=' . $controller . '&' . Link::$action_var . '=' . $action;
		return $page . '?' . $params;
	}

	public static function MakeAnchor($title, $controller, $action, $attributes = array()) {
		$attr = "";
		if(!empty($attributes))
			foreach($attributes as $key => $value)
				$attr += $key . '="' . $value . '"';
		$href = '"' . Link::MakeURL($controller, $action) . '"';
		return "<a href=$href $attr>$title</a>";
	}

	private static function getCurrentUrl($with_params = false) {
		if($with_params)
			return "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		else
			return "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
	}
}