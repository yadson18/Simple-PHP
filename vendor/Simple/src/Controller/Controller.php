<?php 
	namespace Simple\Controller;

	use Simple\Http\Request;
	use Simple\View\View;

	abstract class Controller implements Interfaces\ControllerInterface
	{
		public $Request;

		private $View;

		public function initialize(Request $request, View $view)
		{
			$this->Request = $request;
			
			$this->View = $view;
		}

		public function loadComponent(string $componentName)
		{
			$component = 'Simple\\Controller\\Components\\' . $componentName;

			if (class_exists($component)) {
				$this->$componentName = new $component;
			}
		}
	}