<?php 
	if (version_compare(PHP_VERSION, '5.6.0') < 0) {
	    trigger_error('PHP version must be equal or higher than 5.6.0.', E_USER_ERROR);
	}
	
	if (!extension_loaded('intl')) {
	    trigger_error('You must enable the intl extension.', E_USER_ERROR);
	}
	
	if (!extension_loaded('mbstring')) {
	    trigger_error('You must enable the mbstring extension.', E_USER_ERROR);
	}

	require_once 'paths.php';

	require_once VENDOR . 'Autoload.php';

	Autoload::loadNamespaces();

	require_once CONFIG . 'app-config.php';


	use Simple\Http\Server;

	if ($configurator->getConfig("DefaultErrorPage")) {
		Server::setConfig($configurator->getConfig("DefaultErrorPage"));
	}

	if ($configurator->getConfig("EmailTransport")) {
		Email::setConfig($configurator->getConfig("EmailTransport"));
	}

	if ($configurator->getConfig("DefaultRoute")) {
		Router::setConfig($configurator->getConfig("DefaultRoute"));
	}

	if ($configurator->getConfig("Databases")) {
		Connection::setConfig($configurator->getConfig("Databases"));
	}

	if ($configurator->getConfig("Webservice")) {
		Webservice::setConfig($configurator->getConfig("Webservice"));
	}

	if ($configurator->getConfig("AppName")) {
		Application::setConfig($configurator->getConfig("AppName"));
	}

	if ($configurator->getConfig("DisplayErrors")) {
		ErrorHandler::setConfig($configurator->getConfig("DisplayErrors"));
	}