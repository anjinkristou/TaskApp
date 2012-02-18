<?php

$site_path = realpath(__DIR__);
$success = define('__SITE_PATH', $site_path);
if(!$success) {
	throw new Exception("Cannot define __SITE_PATH constant!");
}
include __SITE_PATH . '/application/' . 'functions.php';
/**
 *
 * In-built PHP function serves as a last hope for a class to be loaded.
 * Only model classes are required to be initialized on demand
 * @param String $classname
 * @throws Exception
 */
function __autoload($class_name) {
	$class_name = preg_replace_callback("([A-Z])", 'lower', $class_name);
	$class_name = substr($class_name, 1);
	$file_path = __SITE_PATH . "/model/$class_name.class.php";
	if(file_exists($file_path))
		include $file_path;
	else
		throw new Exception("Attempt to load unrecognized class!");
}
/**
 * Required application classes
 */
include __SITE_PATH . '/application/' . 'router.class.php';
include __SITE_PATH . '/application/' . 'template.class.php';
include __SITE_PATH . '/application/' . 'link.class.php';
include __SITE_PATH . '/application/' . 'dynamic.class.php';
include __SITE_PATH . '/application/' . 'db.class.php';
include __SITE_PATH . '/application/' . 'element.class.php';
/**
 * Model and Controller base classes
 */
include __SITE_PATH . '/controller/' . 'controller.class.php';
include __SITE_PATH . '/model/' . 'model.class.php';
/**
 *
 * Router object processes request URI
 * and routes application logic to specific controller
 * @var Router
 */
$router = new Router();
$router->Route();



