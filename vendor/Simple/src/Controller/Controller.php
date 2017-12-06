<?php 
	namespace Simple\Controller;

	use Simple\Http\Request;
	use Simple\View\View;

	abstract class Controller implements Interfaces\ControllerInterface
	{
		public $Request;

		private $view;

		public function initialize(Request $request, View $view)
		{
			$this->Request = $request;
			
			$this->view = $view;
		}

		protected function loadComponent(string $componentName)
		{
			$component = 'Simple\\Controller\\Components\\' . $componentName;

			if (class_exists($component)) {
				$this->$componentName = new $component;
			}
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
        				'redirectTo' => $url['controller'] . '/' . $url['view']
        			];
        		}
        		return [
        			'redirectTo' => $url['controller'] . '/index'
        		];
        	}
        	return false;
		}
	}