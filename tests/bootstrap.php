<?php
require_once __DIR__ . '/../vendor/autoload.php';

function autoload_test($class_name) {
	$base_dir = __DIR__ . '/';
	$relative_class = $class_name;
	$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
	if (file_exists($file)) {
		require $file;
	}
}
spl_autoload_register('autoload_test');