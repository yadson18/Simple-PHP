<?php 
	namespace Simple\Controller; 

	use ReflectionClass;

	class Component
	{
		const NAMESPACE = 'Simple\\Controller\\Components\\';

		const SUFIX = 'Component';

		private $componentsRegistry = [];

		private $componentName;

		public function register(string $componentName)
		{
			$component = Component::NAMESPACE . $componentName . Component::SUFIX;

			if ($this->componentExists($component)) {
				$this->setComponent($componentName, new ReflectionClass($component));
			}
		}

		public function getRegistryComponents()
		{
			return $this->componentsRegistry;
		}

		protected function setComponent(string $componentName, ReflectionClass $component)
		{
			$this->componentsRegistry[$componentName] = $component->newInstance();
		}

		protected function componentExists(string $componentName)
		{
			if (class_exists($componentName)) {
				return true;
			}
			return false;
		}
	}