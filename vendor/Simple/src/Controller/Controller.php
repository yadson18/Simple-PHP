<?php 
	namespace Simple\Controller;

	use Simple\Http\Request;
	use Simple\View\View;

	abstract class Controller implements Interfaces\ControllerInterface
	{
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

		protected function redirect($route)
        {
        	if (is_array($route)) {
	        	if (isset($route['controller']) && !empty($route['controller'])) {
	        		if (isset($route['view']) && !empty($route['view'])) {
	        			return ['redirect' => $route['controller'] . '/' . $route['view']];
	        		}
	        		return ['redirect' => $route['controller'] . '/index'];
	        	}
        	}
        	else if (is_string($route)) {
        		return ['redirect' => $route];
        	}
        	return false;
		}

		public static function getNamespace(string $controllerName)
		{
			$controller = 'App\\Controller\\' . $controllerName . 'Controller';

			if (class_exists($controller)) {
				return $controller;
			}
			return false;
		}
	}