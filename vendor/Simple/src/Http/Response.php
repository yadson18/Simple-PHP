<?php 
	namespace Simple\Http;

	use Simple\Controller\Controller;
	use Simple\Routing\Router;
	use Simple\View\View;
	use ReflectionClass;
	use stdClass;

	class Response
	{
		private $request;

		public function __construct(Request $request)
		{
			$this->setRequest($request);
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
			$request = $this->getRequest();
			$header = (!empty($request->getHeader())) ? $request->getHeader() : null;
			$controller = (!empty($header)) ? Controller::getNamespace($header->controller) : null;
			
			if (!empty($header) && !empty($controller)) {
				$url = $header->controller . '/' . $header->view;
				$fullTemplate = TEMPLATE . $header->controller . DS . $header->view . '.php';
				$reflection = new ReflectionClass($controller);
				$instance = $reflection->newInstance();
				$view = new View();

				if (call_user_func_array([$instance, 'isAuthorized'], [$header->view]) &&
					is_callable([$instance, 'initialize']) && 
					is_callable([$instance, $header->view])
				) {
					call_user_func_array([$instance, 'initialize'], [$request, $view]);
					$result = call_user_func_array([$instance, $header->view], $header->args);
					
					if (isset($result['redirect']) && $result['redirect'] !== $url) {
						Router::location($result['redirect']);
					}
					else if (is_file($fullTemplate)) {
						if (isset($instance->Ajax) && 
							call_user_func([$instance->Ajax, 'notEmptyResponse'])
						) {
							$view->setContentType('ajax');
							$view->setViewVars(call_user_func([$instance->Ajax, 'getResponse']));

						}
						else {
							$view->setContentType('default');

						}

						$view->setComponents($instance->getComponents());
						$view->setControllerName($header->controller);
						$view->setTemplatePath(TEMPLATE . $header->controller . DS);
						$view->setTemplate($header->view);

						return (object) [
							'status' => 'success',
							'view' => $view
						];
					}
					
				}
			}
			return (object) [
				'status' => 'error',
				'message' => 'Check if the class ' . $header->controller . 
							 'Controller or template ' . $header->view . ' exists.'
			];
		}
	}