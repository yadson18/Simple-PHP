<?php 
	namespace Simple\Http;

	use Simple\Controller\Interfaces\ControllerInterface;
	use Simple\Routing\Router;
	use Simple\View\View;
	use \stdClass;

	class Request
	{
		private static $namespace = 'App\\Controller\\';

		private $router;

		private $requestType;

		private $requestData;

		private $requestArgs;

		public function __construct(string $urlRequest, string $requestType)
		{
			$this->setHeader($urlRequest, $requestType);
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

		public function getResponse()
		{
			if ($this->getHeader()->response->status === 'success') {
				$header = $this->getHeader();
				
			 } 
		}

		protected function getHeader()
		{
			$controllerName = $this->getRoute()->getController();
			$controller = self::$namespace . $controllerName . 'Controller';
			$view = $this->getRoute()->getView();

			if (class_exists($controller)) {
				$controllerInstance = new $controller();

				if (@call_user_func_array([$controllerInstance, 'isAuthorized'], [$view]) &&
					is_callable([$controllerInstance, 'initialize']) &&
					is_callable([$controllerInstance, $view])
				) {
					$viewInstance = new View($controllerName . DS . $view);

					@call_user_func_array([$controllerInstance, 'initialize'], [$this, $viewInstance]);

					return (object) [
						'request' => (object) [
							'type' => $this->getRequestType(),
							'url' => (object) [
								'controller' => $controllerName,
								'view' => $view
							],
							'args' => $this->getRequestArgs(),
							'data' => $this->getData()
						],
			 			'response' => (object) [
			 				'controller' => $controllerInstance,
							'view' => $viewInstance,
			 				'status' => 'success'
			 			]
					];
				}
			}
			return (object) [
				'request' => (object) [
					'type' => $this->getRequestType(),
					'url' => (object) [
						'controller' => $controllerName,
						'view' => $view
					],
					'args' => $this->getRequestArgs(),
					'data' => $this->getData()
				],
				'response' => (object) [
					'controller' => null,
					'view' => null,
					'status' => 'error'
				]
			];
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
	}