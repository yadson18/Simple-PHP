<?php
	namespace Simple\Application;

	use Simple\Error\ErrorHandler;
	use Simple\Http\Request;
	use Simple\Html\Html;
	use Simple\Html\Form;
	use Simple\View\View;

	class Application
	{
		private static $appName;
		
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

		public function fetch(string $dataIndex)
		{
			if (isset($this->view)) {
				switch ($dataIndex) {
					case 'title': return $this->view->getTitle(); break;
					case 'appName': return $this->getAppName(); break;
					case 'content': 
						ob_start();
						
						if (!empty($this->view->getViewVars())) {
							foreach ($this->view->getViewVars() as $variableName => $value) {
								if (is_string($variableName)) {
									$$variableName = $value;
								}
							}
						}
						require_once $this->view->getTemplate(); 

						return ob_get_clean();
					break;
				}
			}
		}

		public function start(Request $request)
		{
			$response = $request->getResponse();
			$this->view = $response->view;

			if ($response->status === 'success') {
				if ($response->content === 'redirect') {
					header('Location: /' . $response->redirectTo);
				}
				else if($response->content === 'ajax' || $response->content === 'default') {
					$this->Flash = $response->flash;
				}
			}
			else {
				$this->view->setTemplate('daniedAccess');
				$this->view->setTitle('Error');
			}
			
			if ($this->view->canBeRender()) {
				require_once $this->view->getLayout();
			}
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
	}