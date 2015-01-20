<?php
session_start();
/**
 * Autoload the class names
 *
 * @param $class_name
 */
function __autoload($class_name) {
	$class_array = (explode('\\',$class_name));
	$path = __DIR__ . '/' . end($class_array) . '.php';
	if (file_exists($path)) {
		require_once($path);
	}
}