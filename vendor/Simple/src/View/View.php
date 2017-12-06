<?php 
	namespace Simple\View;

	class View
	{
		private static $defaultTemplate = TEMPLATE . 'Layout' . DS . 'default.php';

		private static $errorPage;

		private $title;

		private $viewTemplate;

		private $viewVars;

		public function __construct(string $viewTemplate)
		{
			$this->setViewTemplate($viewTemplate);
		}

		public function isValidTemplate()
		{
			if (is_file($this->getViewTemplate()) && 
				is_file($this->getDefaultTemplate())
			) {
				return true;
			}
			return false;
		}

		public function getDefaultTemplate()
		{
			return static::$defaultTemplate;
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
			return $this->viewTemplate;
		}

		public function setViewVars(array $viewVars)
		{
			$this->viewVars = $viewVars;
		}

		public function getViewVars()
		{
			return $this->viewVars;
		}

		public static function configErrorPage(string $errorPagePath)
		{
			static::$errorPage = $errorPagePath;
		}
	}