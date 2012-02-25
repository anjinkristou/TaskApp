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
		$this->page->styles = array(
			'resources/main.css',
			'jquery/css/custom-theme/jquery-ui-1.8.17.custom.css');
		$this->page->javascripts = array(
			'jquery/js/jquery-1.7.1.min.js',
			'jquery/js/jquery-ui-1.8.17.custom.min.js',
			'resources/main.js' );
	}
	/**
	 *
	 * In order to show anything to client
	 * this method MUST be called.
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