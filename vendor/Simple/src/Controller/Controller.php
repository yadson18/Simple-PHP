<?php 
	namespace Simple\Controller;

	use Simple\Controller\Interfaces\ControllerInterface;
	use Simple\Controller\Component;
	use Simple\ORM\TableRegistry;
	use Simple\Http\Request;
	use Simple\ORM\Table;
	use Simple\View\View;

	abstract class Controller implements ControllerInterface
	{
		const NAMESPACE = 'App\\Controller\\';

		const SUFIX = 'Controller';

		public $Request;

		private $view;

		private $component;

		public function initialize(Request $request, View $view)
		{
			$this->component = new Component();
			
			$this->Request = $request;
			
			$this->view = $view;

			$this->loadTables();
		}

		protected function loadTables()
		{
			$tableName = replace(splitNamespace(get_class($this)), 'Controller', '');
			$table = TableRegistry::get($tableName);

			if (!empty($table)) {
				$this->$tableName = $table;
			}
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

		public static function exists(string $controllerName)
		{
			if (class_exists(Controller::NAMESPACE . $controllerName . Controller::SUFIX)) {
				return true;
			}
			return false;
		}

		public static function getNamespace(string $controllerName)
		{
			$controller = Controller::NAMESPACE . $controllerName . Controller::SUFIX;

			if (class_exists($controller)) {
				return $controller;
			}
			return false;
		}
	}