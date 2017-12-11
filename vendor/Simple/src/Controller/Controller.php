<?php 
	namespace Simple\Controller;

	use Simple\Http\Request;
	use Simple\View\View;

	abstract class Controller implements Interfaces\ControllerInterface
	{
		const CONTROLLER_PATH = 'App\\Controller\\';

		const SUFIX = 'Controller';

		public $Request;

		private $view;

		private $component;

		public function initialize(Request $request, View $view)
		{
			$this->Request = $request;
			
			$this->view = $view;
			
			$this->component = new Component();
		}

		protected function loadComponent(string $componentName)
		{
			$this->component->register($componentName);
			
			foreach ($this->getComponents() as $component => $instance) {
				$this->$component = $instance;
			}
		}

		public function getComponents()
		{
			return $this->component->getRegistryComponents();
		}

		protected function setTitle(string $title)
		{
			$this->view->setTitle($title);
		}

		protected function setViewVars(array $viewVars)
		{
			$this->view->setViewVars($viewVars);
		}

		protected function redirect(array $url)
        {
        	if (isset($url['controller']) && !empty($url['controller'])) {
        		if (isset($url['view']) && !empty($url['view'])) {
        			return [
        				'redirect' => $url['controller'] . '/' . $url['view']
        			];
        		}
        		return [
        			'redirect' => $url['controller'] . '/index'
        		];
        	}
        	return false;
		}

		public static function getNamespace(string $controllerName)
		{
			$controller = Controller::CONTROLLER_PATH . $controllerName . Controller::SUFIX;

			if (class_exists($controller)) {
				return $controller;
			}
			return false;
		}
	}