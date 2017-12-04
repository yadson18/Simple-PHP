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

		public function start(Request $request)
		{
			if ($request->statusCodeIs(200)) {
				$header = $request->getHeader();
				$controller = $header->request->controller;
				$view = $header->request->url->view;

				if (class_exists($controller) && is_file($header->request->page)) {
					debug($header);
				}
			}
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