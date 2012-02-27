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
	 * This method is used by the Router.
	 * The Router finds out whether the controller needs to be authenticated or not.
	 * Authentication is needed by default.
	 */
	public function authNeeded() {
		return true;
	}

	/**
	 *
	 * Every controller MUST have index action method
	 */
	abstract public function index();

}