<?php
	namespace Simple\Application;

	use Simple\Http\Request;

	class Application
	{
		private static $appName;
		
		private static $errorPage;
		
		private static $namespace = 'App\\Controller\\';
		
		private $bootstrapPath;

		public function __construct(string $bootstrapPath)
		{
			$this->setBootstrapPath($bootstrapPath);
		}

		public function start(Request $request)
		{
			$controller = $request->getRoute()->getController();
			$view = $request->getRoute()->getView();
			
			$controllerInstance = $this->getControllerInstance($controller);
		}

		protected function getControllerInstance(string $controller)
		{
			$controller = static::$namespace . $controller . 'Controller';

			if (class_exists($controller)) {
				return new $controller();
			}
		} 

		public function bootstrap()
		{
			if (file_exists($this->getBootstrapPath() . '/bootstrap.php')) {
				include $this->getBootstrapPath() . '/bootstrap.php';
			}

			return $this;
		}

		protected function setBootstrapPath(string $bootstrapPath)
		{
			$this->bootstrapPath = $bootstrapPath;
		}

		public function getBootstrapPath()
		{
			return $this->bootstrapPath;
		}

		public static function configAppName(string $appName)
		{
			static::$appName = $appName;
		}

		public static function configErrorPage(string $errorPagePath)
		{
			static::$errorPage = $errorPagePath;
		}
	}