<?php

class Router {

	private $controller;
	private $action;

	public function Route() {
		// Include controller class and set controller and action parameters
		$this->initController();

		// Has controller class definition presented public method $this->action?
		if(!is_callable(array($this->controller, $this->action)))
			$this->action = 'index';

		$controller = new $this->controller();
		$method = $this->action;
		// Finally call controller method
		$controller->$method();
	}

	private function initController() {
		if(isset($_GET[Link::$controller_var]))
			$controller = $_GET[Link::$controller_var];
		else
			$controller = 'index';

		$controller_file = __SITE_PATH . '/controller/' . $controller . '_controller.class.php';

		if(!file_exists($controller_file))
			throw new Exception("Controller file not found!");
		else
			include($controller_file);


		if(isset($_GET[Link::$action_var]))
			$action = $_GET[Link::$action_var];
		else
			$action = 'index';

		// Set controller class and method names
		$this->controller = ucfirst($controller) . "Controller";
		$this->action = $action;
	}
}