<?php
	namespace Simple\Application;

	use Simple\Http\Request;

	class Application
	{
		private static $appName;
		
		private static $errorPage;
		
		private $bootstrapPath;

		private $bootstrapIsLoaded = false; 

		public function __construct(string $bootstrapPath)
		{
			$this->setBootstrapPath($bootstrapPath);
		}

		public function fetchAll()
		{

		}

		public function start(Request $request)
		{
			debug($request->getResponse());
			/*$controller = $header->request->controller;
				$view = $header->request->url->view;

				if (class_exists($controller)) {
					return $this->makeRequest($header, new $controller, $view);
				}
			include $request->getResponse();
			if (is_callable([$controller, 'isAuthorized']) &&
				is_callable([$controller, 'initialize'])
			) {
				if ($controller->isAuthorized($view)) {
					$controller->initialize($this); 
					$result = $controller->$view($header->request->args);

					if ($controller->Ajax->notEmptyResponse()) {
						echo $controller->Ajax->getResponse();

						exit();
					}
					else if(is_file($header->request->page)) {
						ob_start();

						$this->Html = $controller->Html;
						$this->Ajax = $controller->Ajax;

						include static::$defaultTemplate;

						return ob_get_clean();
					}
				}
			}*/
		}

		public function bootstrap()
		{
			if (file_exists($this->getBootstrapPath() . 'bootstrap.php')) {
				$this->bootstrapIsLoaded();

				include $this->getBootstrapPath() . 'bootstrap.php';
			}

			return $this;
		}

		protected function bootstrapIsLoaded()
		{
			$this->bootstrapIsLoaded = true;
		}

		public function bootstrapFileStatus()
		{
			return $this->bootstrapIsLoaded;
		}

		protected function setBootstrapPath(string $bootstrapPath)
		{
			$this->bootstrapPath = $bootstrapPath;
		}

		protected function getBootstrapPath()
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