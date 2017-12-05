<?php 
	namespace Simple\Controller;

	use Simple\Http\Request;

	abstract class Controller implements Interfaces\ControllerInterface
	{
		public function initialize(Request $request)
		{
			$this->Request = $request;
		}

		public function loadComponent(string $componentName)
		{
			$component = 'Simple\\Controller\\Components\\' . $componentName;

			if (class_exists($component)) {
				$this->$componentName = new $component;
			}
		}
	}