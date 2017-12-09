<?php
	namespace Simple\Application;

	use Simple\Error\ErrorHandler;
	use Simple\Http\Request;
	use Simple\Html\Html;
	use Simple\Html\Form;
	use Simple\View\View;

	use Simple\Controller\Component;

	class Application
	{
		private static $appName;

		private $controllerName;

		private $viewName;
		
		private $bootstrapPath;

		private $error;

		private $view;

		public $Html;

		public $Form;

		public function __construct(string $bootstrapPath)
		{
			$this->setBootstrapPath($bootstrapPath);
			$this->error = new ErrorHandler();
			$this->Html = new Html();
			$this->Form = new Form();
		}

		public function start(Request $request)
		{
			debug($request->send()->result());

			/*$response = $request->getResponse();
			$this->view = $response->view;

			if ($response->status === 'success') {
				if ($response->content === 'redirect') {
					header('Location: /' . $response->redirectTo);
				}
				else if($response->content === 'ajax' || $response->content === 'default') {
					$this->setControllerName($response->pageInfo->controllerName);
					$this->setViewName($response->pageInfo->viewName);
					$this->Flash = $response->flash;

					if (empty($this->view->getTitle())) {
						$this->view->setTitle($this->getViewName());
					}
				}
			}
			else {
				$this->view->setTemplate('daniedAccess');
				$this->view->setTitle('Error');
			}
			
			if ($this->view->canBeRender()) {
				require_once $this->view->getLayout();
			}*/
		}

		public function bootstrap()
		{
			if (file_exists($this->getBootstrapPath() . 'bootstrap.php')) {
				require_once $this->getBootstrapPath() . 'bootstrap.php';

				return true;
			}
			return false;
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

		public function getAppName()
		{
			return static::$appName;
		}

		protected function setControllerName(string $controllerName)
		{
			$this->controllerName = $controllerName;
		}
		
		protected function getControllerName()
		{
			return $this->controllerName;
		}

		protected function setViewName(string $viewName)
		{
			$this->viewName = $viewName;
		}

		protected function getViewName()
		{
			return $this->viewName;
		}
	}