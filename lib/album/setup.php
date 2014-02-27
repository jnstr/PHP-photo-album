<?php
session_start();

/**
 * Autoload the class names
 *
 * @param $class_name
 */
function __autoload($class_name) {
	require_once($class_name . '.php');
}