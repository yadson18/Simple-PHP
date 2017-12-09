<?php 
	namespace Simple\Http;

	use Simple\Controller\Controller;
	use Simple\Routing\Router;
	use Simple\View\View;
	use ReflectionClass;

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
					else if (isset($instance->Ajax) && 
						call_user_func([$instance->Ajax, 'notEmptyResponse'])
					) {
						$view->setContentType('ajax');

					}
					else {
						$view->setContentType('default');

					}
						
					$view->setTemplatePath(TEMPLATE . $header->controller . DS);
					$view->setTemplate($header->view);

					//$view->render();
					//$view->setContent('/var/www/Simple-PHP/src/Template/Page/home.php');
					return $view;
				}
			}
		}
	}