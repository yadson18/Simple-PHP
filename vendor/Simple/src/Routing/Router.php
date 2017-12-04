<?php 
	namespace Simple\Routing;

	class Router
	{
		private static $defaultController;

		private static $defaultView;

		private $controller;

		private $view = 'index';

		public function __construct(string $controller, string $view)
		{
			$this->setRoute(['controller' => $controller, 'view' => $view]);
		}

		public static function configRoute(array $defaultRoute)
		{
			if (isset($defaultRoute['controller']) && isset($defaultRoute['view'])) {
				static::setDefaultController($defaultRoute['controller']);
				static::setDefaultView($defaultRoute['view']);
			}
		}

		protected function setDefaultController(string $controller)
		{
			static::$defaultController = ucfirst($controller);
		}

		protected function getDefaultController()
		{
			return static::$defaultController;
		}

		protected function setDefaultView(string $view)
		{
			static::$defaultView = $view;
		}

		protected function getDefaultView()
		{
			return static::$defaultView;
		}

		protected function setController(string $controller)
		{
			$this->controller = ucfirst($controller);
		}

		public function getController()
		{
			return $this->controller;
		}

		protected function setView(string $view)
		{
			$this->view = $view;
		}

		public function getView()
		{
			return $this->view;
		}

		public function setRoute(array $route)
		{
			if (isset($route['controller']) && isset($route['view'])) {
				if (empty($route['controller'])) {
					$this->setController(static::getDefaultController());
					$this->setView(static::getDefaultView());
				}
				else {
					if (!empty($route['view'])) {
						$this->setView($route['view']);
					}
					
					$this->setController($route['controller']);
				}
			}
		}
	}