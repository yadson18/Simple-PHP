<?php
	define('DS', DIRECTORY_SEPARATOR);

	define('ROOT', dirname(__DIR__));

	define('APP_DIR', 'src');

	define('APP', ROOT . DS . APP_DIR . DS);

	define('CONTROLLER', APP . 'Controller' . DS);

	define('MODEL', APP . 'Model' . DS);

	define('TEMPLATE', APP . 'Template' . DS);

	define('CONFIG', ROOT . DS . 'config' . DS);

	define('VENDOR', ROOT . DS . 'vendor' . DS);

	define('SIMPLE_PATH', VENDOR . 'Simple' . DS);

	define('SIMPLE', SIMPLE_PATH . 'src' . DS);

	define('WWW_ROOT', ROOT . DS . 'webroot' . DS);