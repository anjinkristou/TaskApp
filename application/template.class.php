<?php

class Template {

	private $page;
	private $model;
	private $has_model = false;
	private $top_level_template;

	public function __construct() {
		// Set default values
		$this->top_level_template = 'index';
		$this->page = new Dynamic();
		$this->page->title = "Taskapp";
		$this->page->template = 'content';
		$this->page->style = 'view/main.css';
	}
	/**
	 *
	 * In order to show anything to client
	 * each controller MUST call this method.
	 *
	 * Optional Model object parameter will be rendered.
	 *
	 * @param mixed $model
	 */
	public function show($model = array()) {

		if(!empty($model)) {
			$this->model = $model;
			$this->has_model = true;
		}
		// RENDER VIEW
		include $this->getFileTemplate($this->top_level_template);
	}

	public function setContent($content) {
		$this->content = $content->data;
	}

	private function getFileTemplate($template_name) {
		$file_path = __SITE_PATH . "/view/$template_name.tpl.php";
		if(!file_exists($file_path))
			throw new Exception("Unrecognized view template!");
		return $file_path;
	}
}