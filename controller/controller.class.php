<?php

abstract class Controller {

	protected $view;

	/**
	 *
	 * FIX: Child constructors has to call this ctor explicitly in order to create view!!!
	 */
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