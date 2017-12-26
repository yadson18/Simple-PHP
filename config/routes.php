<?php 
	use Simple\Routing\Router;

	Router::configRoutes([
		'default' => ['controller' => 'Page', 'view' => 'home']
	]);