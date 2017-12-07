<?php 
/*	if (version_compare(PHP_VERSION, '5.6.0') < 0) {
	    trigger_error('PHP version must be equal or higher than 5.6.0.', E_USER_ERROR);
	}
	
	if (!extension_loaded('intl')) {
	    trigger_error('You must enable the intl extension.', E_USER_ERROR);
	}
	
	if (!extension_loaded('mbstring')) {
	    trigger_error('You must enable the mbstring extension.', E_USER_ERROR);
	}*/

	require_once SIMPLE . 'internal-functions.php';
	require_once CONFIG . 'app-config.php';

	$config->mbInternalEncoding($config->use('App.encoding'));

	$config->dateDefaultTimezone($config->use('App.timezone'));

	$config->defaultLocale($config->use('App.locate'));

	$config->displayErrors($config->use('App.displayErrors'));


	use Simple\Application\Application;
	use Simple\Error\ErrorHandler;
	use Simple\Routing\Router;
	use Simple\Html\Html;
	use Simple\View\View;
	/*use Simple\Database\Database;
	use Simple\Mailer\Email;*/
	/*use Simple\Http\Integrator\Webservice;*/

	ErrorHandler::configPageError($config->use('App.errorPage'));
	Application::configAppName($config->use('App.name'));
	View::configErrorPage($config->use('App.errorPage'));
	Html::configEncode($config->use('App.encoding'));
	Router::configRoute($config->use('Route.default'));
	/*Database::configDatabase($config->use('Databases'));
	Email::configEmail($config->use('Email.default'));*/
	/*Webservice::configConnection($config->use('Webservice'));*/