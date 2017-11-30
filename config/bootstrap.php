<?php 
	/*if (version_compare(PHP_VERSION, '5.6.0') < 0) {
	    trigger_error('PHP version must be equal or higher than 5.6.0.', E_USER_ERROR);
	}
	
	if (!extension_loaded('intl')) {
	    trigger_error('You must enable the intl extension.', E_USER_ERROR);
	}
	
	if (!extension_loaded('mbstring')) {
	    trigger_error('You must enable the mbstring extension.', E_USER_ERROR);
	}*/

	require_once 'paths.php';

	require_once VENDOR . 'Autoload.php';

	Autoload::loadNamespaces();

	include CONFIG . 'app-config.php';