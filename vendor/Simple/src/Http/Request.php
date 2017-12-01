<?php 
	namespace Simple\Http;

	use Simple\Routing\Router;

	class Request
	{
		private $router;

		private $requestMethod;

		private $controller;

		private $controllerMethod;

		private $methodArgs;

		public function __construct()
		{
			$this->router = new Router();
			$this->convertUrl($_SERVER['REQUEST_URI']);
			$this->setRequestMethod($_SERVER['REQUEST_METHOD']);
		}

		protected function convertUrl(string $url)
		{
			$methodArgs = explode("/", substr($url, 1));
			$controller = array_shift($methodArgs);
			$controllerMethod = array_shift($methodArgs);

            $this->setControllerMethod($controllerMethod);
            $this->setController($controller);
            $this->setMethodArgs($methodArgs);
		}

		protected function setRequestMethod(string $requestMethod)
		{
			$this->requestMethod = $requestMethod;
		}

		public function getRequestMethod()
		{
			return $this->requestMethod;
		}

		protected function setController(string $controller = null)
		{
			if (!empty($controller)) {
				$this->controller = ucfirst($controller);
			}
			else {
				$this->controller = ucfirst(Router::getDefaultRoute('controller'));
				$this->setControllerMethod(Router::getDefaultRoute('view'));
			}
		}

		public function getController()
		{
			return $this->controller;
		}

		protected function setControllerMethod(string $controllerMethod = null)
		{
			if (!empty($controllerMethod)) {
				$this->controllerMethod = $controllerMethod;
			}
			else {
				$this->controllerMethod = 'index';
			}
		}

		public function getControllerMethod()
		{
			return $this->controllerMethod;
		}

		protected function setMethodArgs(array $methodArgs)
		{
			$this->methodArgs = $methodArgs;
		}

		public function getMethodArgs()
		{
			return $this->methodArgs;
		}
	}