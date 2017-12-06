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
			$result = $request->getResponse();

			if ($result->response->status === 'success') {
				$controllerInstance = $result->response->controller;
				$viewInstance = $result->response->view;
				
				$result = @call_user_func_array(
					[$controllerInstance, $result->request->url->view], [$result->request->args]
				);

				if (isset($result['redirect'])) {
					echo 'redirect';
				}
				else if (isset($controllerInstance->Ajax) && 
						 $controllerInstance->Ajax->notEmptyResponse()
				) {
					echo $controllerInstance->Ajax->getResponse();
					exit();
				}
				else {
					echo 'Get page';
				}
			}
			else {
				echo 'Fail';
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