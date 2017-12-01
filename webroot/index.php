<?php 
	require_once dirname(__DIR__) . '/config/paths.php';

	require_once VENDOR . 'Autoload.php';

	Autoload::loadNamespaces();


	use Simple\Http\Server;
	use Simple\Application\Application;

	$server = new Server(new Application(CONFIG));

	$server->run();


	//var_dump(parse_url(urldecode($_SERVER['REQUEST_URI']))); echo "<br>";
	//var_dump(urldecode($_SERVER['REQUEST_URI'])); echo "<br>";

	//var_dump(parse_url(urldecode($_SERVER['REQUEST_URI'])));