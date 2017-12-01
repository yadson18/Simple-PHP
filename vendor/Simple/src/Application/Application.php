<?php
	namespace Simple\Application;

	use Simple\Http\Request;

	class Application
	{
		private $bootstrapPath;

		private static $appName;

		private static $errorPage;

		public function __construct(string $bootstrapPath)
		{
			$this->setBootstrapPath($bootstrapPath);
		}

		public function start(Request $request)
		{

		}

		public function bootstrap()
		{
			if (file_exists($this->bootstrapPath . '/bootstrap.php')) {
				include $this->bootstrapPath . '/bootstrap.php';
			}

			return $this;
		}

		protected function setBootstrapPath(string $bootstrapPath)
		{
			$this->bootstrapPath = $bootstrapPath;
		}

		public function getBootstrapPath()
		{
			return $this->bootstrapPath;
		}

		public static function configAppName(string $appName)
		{
			static::$appName = $appName;
		}

		public static function configErrorPage(string $errorPagePath)
		{
			static::$errorPage = $errorPagePath;
		}
	}