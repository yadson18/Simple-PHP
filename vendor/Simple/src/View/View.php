<?php 
	namespace Simple\View;

	class View
	{
		private static $errorPage;

		private $layout = TEMPLATE . 'Layout' . DS;

		private $contentType;
		
		private $templatePath;

		private $title;

		private $template;
	
		private $viewVars;


		public function initialize(string $contentType, string $templatePath)
		{
			$this->setContentType($contentType);
			$this->setTemplatePath($templatePath);
		}

		public function canBeRender()
		{
			if (is_file($this->getLayout()) && is_file($this->getTemplate())) {
				return true;
			}
			return false;
		}

		public function setContentType(string $contentType)
		{
			$this->contentType = $contentType;
		}

		public function getContentType()
		{
			return $this->contentType;
		}

		public function getLayout()
		{
			return $this->layout . $this->getContentType() . '.php';
		}

		protected function setTemplatePath(string $templatePath)
		{
			$this->templatePath = $templatePath;
		}

		protected function getTemplatePath()
		{
			return $this->templatePath;
		}

		public function setTitle(string $title)
		{
			$this->title = $title;
		}

		public function getTitle()
		{
			return $this->title;
		}

		public function setTemplate(string $template)
		{
			$this->template = $template . '.php';
		}

		public function getTemplate()
		{
			return $this->getTemplatePath() . $this->template;
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