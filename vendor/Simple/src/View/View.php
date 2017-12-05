<?php 
	namespace Simple\View;

	class View
	{
		private static $defaultTemplate = TEMPLATE . 'Layout' . DS . 'default.php';

		private $title;

		private $viewTemplate;

		private $viewVars;

		public function __construct(string $viewTemplate)
		{
			$this->setViewTemplate($viewTemplate);
		}

		public function getDefaultTemplate()
		{
			if (is_file(static::$defaultTemplate)) {
				return static::$defaultTemplate;
			}
			return false;
		}

		public function setTitle(string $title)
		{
			$this->title = $title;
		}

		public function getTitle()
		{
			return $this->title;
		}

		protected function setViewTemplate(string $viewTemplate)
		{
			$this->viewTemplate = TEMPLATE . $viewTemplate . '.php';
		}

		public function getViewTemplate()
		{
			if (is_file($this->viewTemplate)) {
				return $this->viewTemplate;
			}
			return false;
		}

		public function setViewVars(array $viewVars)
		{
			$this->viewVars = $viewVars;
		}

		public function getViewVars()
		{
			return $this->viewVars;
		}
	}