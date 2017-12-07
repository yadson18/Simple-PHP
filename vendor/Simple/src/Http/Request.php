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
			$viewInstance = new View();
			$controller = $this->getRoute()->getController();
			$view = $this->getRoute()->getView();
			$url = $controller . '/' . $view;
			$classNamespace = self::$namespace . $controller . 'Controller';

			if (class_exists($classNamespace)) {
				$controllerInstance = new $classNamespace();

				if (@call_user_func_array([$controllerInstance, 'isAuthorized'], [$view])) {
					if (is_callable([$controllerInstance, 'initialize']) &&
						is_callable([$controllerInstance, $view])
					) {
						$viewInstance->setTemplate($view);
						call_user_func_array(
							[$controllerInstance, 'initialize'], [$this, $viewInstance]
						);
						$result = call_user_func_array(
							[$controllerInstance, $view], $this->getRequestArgs()
						);

						if (isset($result['redirect']) && $result['redirect'] !== $url) {
							return (object) [
								'content' => 'redirect',
								'redirectTo' => $result['redirect'],
								'status' => 'success'
							];
						}
						else {
							$flash = (isset($controllerInstance->Flash)) ? $controllerInstance->Flash : null;

							if (isset($controllerInstance->Ajax) && 
								call_user_func([$controllerInstance->Ajax, 'notEmptyResponse']) &&
								is_callable([$controllerInstance->Ajax, 'getResponse'])
							) {
								$viewInstance->initialize('ajax', TEMPLATE . $controller . DS);
								$viewInstance->setViewVars(
									call_user_func([$controllerInstance->Ajax, 'getResponse'])
								);

								return (object) [
									'content' => 'ajax',
									'flash' => $flash,
									'view' => $viewInstance,
									'status' => 'success'
								];
							}
							$viewInstance->initialize('default', TEMPLATE . $controller . DS);
							
							return (object) [
								'content' => 'default',
								'flash' => $flash,
								'view' => $viewInstance,
								'status' => 'success'
							];
						}
					}
				}
			}
			$viewInstance->initialize('error', TEMPLATE . 'Error' . DS);

			return (object) [
				'content' => 'error',
				'view' => $viewInstance,
				'status' => 'error'
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