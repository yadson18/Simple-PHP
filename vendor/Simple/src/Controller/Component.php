<?php 
	namespace Simple\Controller; 

	use ReflectionClass;

	class Component
	{
		private $componentsRegistry = [];

		private $componentName;

		const NAMESPACE = 'Simple\\Controller\\Components\\';

		const SUFIX = 'Component';

		public function register(string $componentName)
		{
			$this->setComponentName($componentName);

			if ($this->componentExists()) {
				$this->setComponent($componentName, new ReflectionClass($this->getComponentName()));
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

		protected function componentExists()
		{
			if (class_exists($this->getComponentName())) {
				return true;
			}
			return false;
		}

		protected function setComponentName(string $componentName)
		{
			$this->componentName = Component::NAMESPACE . $componentName . Component::SUFIX;
		}

		protected function getComponentName()
		{
			return $this->componentName;
		}
	}