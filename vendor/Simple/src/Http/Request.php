<?php 
	namespace Simple\Http;

	use \stdClass;
	use Simple\Routing\Router;

	class Request
	{
		private static $namespace = 'App\\Controller\\';

		private $router;

		private $requestType;

		private $requestData;

		private $requestArgs;

		public function __construct(string $urlRequest, string $requestType)
		{
			$this->setHeader($urlRequest, $requestType)->makeRequest();
		}

		protected function setHeader(string $urlRequest, string $requestType)
		{
			$requestArgs = explode("/", substr($urlRequest, 1));
			$controller = (string) array_shift($requestArgs);
			$view = (string) array_shift($requestArgs);
			
			$this->setRequestType($requestType);	
			$this->setRoute(new Router($controller, $view));
            $this->setRequestArgs($requestArgs);

			if ($requestType === 'GET' || $requestType === 'POST' || 
				$requestType === 'PUT' || $requestType === 'DELETE'
			) {
            	$this->setRequestData($_REQUEST);
			}

			return $this;
		}

		public function getHeader()
		{
			$controller = $this->getRoute()->getController();
			$view = $this->getRoute()->getView();
			
			return (object) [
				'request' => (object) [
					'type' => $this->getRequestType(),
					'url' => (object) [
						'controller' => $controller,
						'view' => $view
					],
					'page' =>  VIEW . $controller . DS . $view . '.php',
					'controller' => self::$namespace . $controller . 'Controller',
					'args' => $this->getRequestArgs(),
					'data' => $this->getData()
				]
			];
		}

		protected function getStatusCode()
		{
			return http_response_code();
		}

		public function statusCodeIs(int $statusCode)
		{
			if ($statusCode === $this->getStatusCode()) {
				return true;
			}
			return false;
		}

		protected function setRequestType(string $requestType)
		{
			$this->requestType = $requestType;
		}

		protected function getRequestType()
		{
			return $this->requestType;
		}

		public function is(string $requestType)
		{
			if ($this->getRequestType() === $requestType) {
				return true;
			}
			return false;
		}

		public function getData()
		{
			return $this->requestData;
		}

		protected function setRequestData(array $requestData)
		{
			$this->requestData = (object) $requestData;
		}

		protected function setRequestArgs(array $requestArgs)
		{
			$this->requestArgs = $requestArgs;
		}

		protected function getRequestArgs()
		{
			return $this->requestArgs;
		}

		protected function setRoute(Router $router)
		{
			$this->router = $router;
		}

		protected function getRoute()
		{
			return $this->router;
		}

		protected function makeRequest()
		{
			return $this->getHeader();
		}
	}