<?php 
	namespace Simple\Http;

	use Simple\Controller\Controller;
	use Simple\Routing\Router;
	use Simple\Http\Request;
	use Simple\View\View;
	use ReflectionClass;
	use stdClass;

	class Response
	{
		private $request;

		private $code;

		private $status;

		public function __construct(Request $request)
		{
			$this->setRequest($request);
		}

		protected function setStatus(int $code)
		{
			switch ($code) {
				case 200: $this->status = 'success'; break;
				case 301: $this->status = 'moved permanently'; break;
				case 400: $this->status = 'bad request'; break;
				case 401: $this->status = 'unauthorized'; break;
				case 403: $this->status = 'forbidden'; break;
				case 404: $this->status = 'not found'; break;
				case 500: $this->status = 'internal server error'; break;
			}
		}

		protected function getStatus()
		{
			return $this->status;
		}

		protected function setCode(int $code)
		{
			$this->setStatus($code);
			$this->code = $code;
		}

		protected function getCode()
		{
			return $this->code;
		}

		protected function setRequest(Request $request)
		{
			$this->request = $request;
		}

		protected function getRequest()
		{
			return $this->request;
		}

		public function result()
		{
			$view = new View();
			$request = $this->getRequest();

			if (!empty($request->getHeader())) {
				$header = $request->getHeader();

				if (!empty($header) && Controller::exists($header->controller)) {
					$fullTemplate = TEMPLATE . $header->controller . DS . $header->view . '.php';
					$controllerName = Controller::getNamespace($header->controller);
					$reflection = new ReflectionClass($controllerName);
					$controller = $reflection->newInstance();

					if (call_user_func_array([$controller, 'isAuthorized'], [$header->view]) &&
						is_callable([$controller, 'initialize']) && 
						is_callable([$controller, $header->view])
					) {	
						call_user_func_array(
							[$controller, 'initialize'], [$request, $view]
						);
						$result = call_user_func_array(
							[$controller, $header->view], $header->args
						);

						if (isset($result['redirect'])) {
							Router::location($result['redirect']);
						}
						else if (is_file($fullTemplate)) {
							if (isset($controller->Ajax) && 
								call_user_func([$controller->Ajax, 'notEmptyResponse'])
							) {
								$view->setContentType('ajax');
								$view->setViewVars(call_user_func([$controller->Ajax, 'getResponse']));

							}
							else {
								$view->setContentType('default');
							}

							$view->setComponents($controller->getComponents());
							$view->setControllerName($header->controller);
							$view->setTemplatePath(TEMPLATE . $header->controller . DS);
							$view->setTemplate($header->view);	
							$this->setCode(200);
						}
						else {
							$this->setCode(404);
						}
					}
					else {
						$this->setCode(403);
					}
				}
				else {
					$this->setCode(400);
				}
			}
			else {
				$this->setCode(400);
			}

			if ($this->getCode() !== 200) {
				$view->setContentType('error');
				$view->setTemplatePath(TEMPLATE . 'Error' . DS);
			}

			return (object) [
				'code' => $this->getCode(),
				'status' => $this->getStatus(),
				'view' => $view
			];
		}
	}