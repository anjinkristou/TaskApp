<?php

class Model {

	private $template;

	public function displayTemplate() {
		$file_path = __SITE_PATH . '/view/' . $this->template . '.tpl.php';
		if(file_exists($file_path))
			include $file_path;
		else
			throw new Exception("Trying to render unrecognized model class " . __CLASS__);
	}

	public function setTemplate($template) {
		$this->template = $template;
	}

}