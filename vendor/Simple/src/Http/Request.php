<?php 
	namespace Simple\Http;

	use Simple\Routing\Router;

	class Request
	{
		private $router;

		private $requestType;

		private $requestArgs;

		public function __construct(string $urlRequest, string $requestType)
		{
			$this->splitUrl($urlRequest);
			$this->setRequestType($requestType);		
		}

		protected function splitUrl(string $url)
		{
			$requestArgs = explode("/", substr($url, 1));
			$controller = (string) array_shift($requestArgs);
			$view = (string) array_shift($requestArgs);

			$this->setRoute(new Router($controller, $view));
            $this->setRequestArgs($requestArgs);
		}

		protected function setRequestType(string $requestType)
		{
			$this->requestType = $requestType;
		}

		public function getRequestType()
		{
			return $this->requestType;
		}

		protected function setRequestArgs(array $requestArgs)
		{
			$this->requestArgs = $requestArgs;
		}

		public function getRequestArgs()
		{
			return $this->requestArgs;
		}

		protected function setRoute(Router $router)
		{
			$this->router = $router;
		}

		public function getRoute()
		{
			return $this->router;
		}
	}