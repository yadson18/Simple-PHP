<?php 
	namespace Simple\Http;

	use Simple\Routing\Router;
	use Simple\Http\Response;
	use stdClass;

	class Request
	{
		private $requestMethod;

		private $requestController;

		private $requestView;

		private $requestData;

		private $requestArgs;

		public function __construct(string $urlRequest, string $requestMethod)
		{
			$this->setHeader($urlRequest, $requestMethod);
		}

		protected function setHeader(string $urlRequest, string $requestMethod)
		{
			$requestArgs = explode("/", substr($urlRequest, 1));
			$controller = (string) array_shift($requestArgs);
			$view = (string) array_shift($requestArgs);
			
			$route = new Router($controller, $view);
			$this->setRequestMethod($requestMethod);
			$this->setRequestController($route->getController());
			$this->setRequestView($route->getView());
			$this->setRequestArgs($requestArgs);

			if ($requestMethod === 'GET' || $requestMethod === 'POST' || 
				$requestMethod === 'PUT' || $requestMethod === 'DELETE'
			) {
            	$this->setRequestData($_REQUEST);
			}
		}

		public function getHeader()
		{
			return (object) [
				'requestMethod' => $this->getRequestMethod(),
				'controller' => $this->getRequestController(),
				'view' => $this->getRequestView(),
				'requestData' => $this->getRequestData(),
				'args' => $this->getRequestArgs()
			];
		}

		public function send()
		{
			return new Response($this);
		}

		protected function setRequestMethod(string $requestMethod){
			$this->requestMethod = $requestMethod;
		}

		protected function getRequestMethod(){
			return $this->requestMethod;
		}

		protected function setRequestController(string $requestController){
			$this->requestController = $requestController;
		}

		protected function getRequestController(){
			return $this->requestController;
		}

		protected function setRequestView(string $requestView){
			$this->requestView = $requestView;
		}

		protected function getRequestView(){
			return $this->requestView;
		}

		protected function setRequestData(array $requestData){
			$this->requestData = $requestData;
		}

		public function getRequestData(){
			return $this->requestData;
		}

		protected function setRequestArgs(array $requestArgs){
			$this->requestArgs = $requestArgs;
		}

		public function getRequestArgs(){
			return $this->requestArgs;
		}

		public function is(string $requestMethod)
		{
			if ($this->getRequestMethod() === $requestMethod) {
				return true;
			}
			return false;
		}
	}