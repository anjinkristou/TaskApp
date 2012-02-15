<?php

abstract class Controller {

	protected $view;

	public function __construct() {
		$this->view = $this->createView();
	}

	protected function createView() {
		return new Template();
	}

	/**
	 *
	 * Every controller MUST have index action method
	 */
	abstract public function index();

}