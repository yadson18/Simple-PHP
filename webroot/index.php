<?php 
	include dirname(__DIR__) . '/config/paths.php';

	require dirname(__DIR__) . '/vendor/Autoload.php';
	
	Autoload::loadNameSpaces();

	//var_dump(parse_url(urldecode($_SERVER['REQUEST_URI']))); echo "<br>";
	//var_dump(urldecode($_SERVER['REQUEST_URI'])); echo "<br>";

	//var_dump(parse_url(urldecode($_SERVER['REQUEST_URI'])));