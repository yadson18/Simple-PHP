<?php 
	namespace Simple\View;

	use Simple\Html\Html;
	use Simple\Html\Form;

	class View
	{
		const LAYOUT = TEMPLATE . 'Layout' . DS;

		const EXT = '.php';

		const AJAX = 'ajax' . View::EXT;

		const ERROR = 'error' . View::EXT;

		const DEFAULT = 'default' . View::EXT;

		private $contentType;

		private $templatePath;

		private $template;

		private $title;

		private $viewVars;

		private $content;

		public function __construct()
		{
			$this->Html = new Html();
			$this->Form = new Form();
		}

		public function setComponents(array $components)
		{
			foreach ($components as $componentName => $instance) {
				$this->$componentName = $instance;
			}
		}
		public function fetch(string $dataIndex)
		{
			/*if (isset($this->view)) {
				switch ($dataIndex) {
					case 'title': return $this->view->getTitle(); break;
					case 'controllerName': return $this->getControllerName(); break;
					case 'viewName': return $this->getViewName(); break;
					case 'appName': return $this->getAppName(); break;
					case 'content': 
						ob_start();
						
						if (!empty($this->view->getViewVars())) {
							foreach ($this->view->getViewVars() as $variableName => $value) {
								if (is_string($variableName)) {
									$$variableName = $value;
								}
							}
						}

						require_once $this->view->getTemplate(); 

						return ob_get_clean();
					break;
				}
			}*/
		}

		public function setContentType(string $contentType)
		{
			$this->contentType = $contentType;
		}

		public function getContentType()
		{
			return $this->contentType;
		}

		public function setTemplatePath(string $templatePath){
			$this->templatePath = $templatePath;
		}

		protected function getTemplatePath(){
			return $this->templatePath;
		}

		public function setTemplate(string $template){
			$this->template = $template;
		}

		protected function getTemplate(){
			return $this->template;
		}

		protected function setContent(string $template)
		{
			if (file_exists($template)) {
				ob_start();

				if (!empty($this->getViewVars())) {
					foreach ($this->getViewVars() as $variable => $value) {
						if (is_string($variable)) {
							$$variable = $value;
						}
					}
				}

				require_once $template;

				$this->content = ob_get_clean();
			}
		}

		protected function getContent()
		{
			return $this->content;
		}

		protected function getLayoutContent(string $layout)
		{
			if (file_exists($layout)) {
				ob_start();

				require_once $layout;

				return ob_get_clean();
			}
		}

		public function render()
		{
			switch ($this->getContentType()) {
				case 'ajax':
					echo $this->getLayoutContent(View::LAYOUT . View::AJAX);
					break;
				case 'default':
					echo $this->getLayoutContent(View::LAYOUT . View::DEFAULT);
					break;
				default:
					echo $this->getLayoutContent(View::LAYOUT . View::ERROR);
					break;
			}
			$this->setContent($this->getTemplatePath() . $this->getTemplate() . View::EXT);
		}

		public function setTitle(string $title)
		{
			$this->title = $title;
		}

		public function getTitle()
		{
			return $this->title;
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