<?php

class Router {

	private $controller;
	private $controller_class;
	private $action;

	public static $instance = null;

	public function __construct() {
		Router::$instance = $this;
	}

	public static function Reroute($controller, $action = "") {
		if(!Router::$instance)
			Router::$instance = new Router();

		Router::$instance->loadController($controller);
		$class_name = Router::$instance->getControllerClassName($controller);
		$instance = new $class_name();
		Router::$instance->executeAction($instance, $action);
	}

	public function Route() {
		// Include Ajax controller base class
		if(isset($_GET['m']))
			if($_GET['m'] == 'ajax')
				include __SITE_PATH . '/controller/ajax_controller.class.php';
		// Load controller
		$controller_name = $this->getController();
		$this->loadController($controller_name);
		// Instantiate controller
		$class_name = $this->getControllerClassName($controller_name);
		$controller = new $class_name();
		// Is controller access restricted?
		if($controller->authNeeded() && !Session::isAuthenticated()) {
			// Route to login screen if there is no authed session
			$this->loadController("login");
			$controller = new LoginController();
		}
		// Execute controller action
		$action = $this->getAction();
		$this->executeAction($controller, $action);
	}

	private function getControllerClassName($controller) {
		$parts = explode('_', $controller);
		$class_name = "";
		foreach($parts as $p) {
			$class_name .= ucfirst($p);
		}
		return $class_name . "Controller";
	}

	private function getController() {
		if(isset($_GET[Link::$controller_var]))
			return $_GET[Link::$controller_var];
		return "index";
	}

	private function getAction() {
		if(isset($_GET[Link::$action_var]))
			return $_GET[Link::$action_var];
		return 'index';
	}

	private function executeAction($controller, $action) {
		// Has controller class definition presented public method $this->action?
		if(!method_exists($controller, $action))
			$action = 'index';
		// Finally call controller method
		$controller->$action();
	}

	/**
	 *
	 * Loads controller file if exists and returns success value.
	 * @param String $controller_name
	 * @throws Exception
	 */
	private function loadController($controller_name) {
		$controller_file = __SITE_PATH . '/controller/' . $controller_name . '_controller.class.php';
		if(file_exists($controller_file)) {
			include_once($controller_file);
			return true;
		}
		else {
			throw new Exception("Controller file not found!");
			return false;
		}
	}
}