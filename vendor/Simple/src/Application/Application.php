<?php
	namespace Simple\Application;

	use Simple\Http\Request;

	class Application
	{
		private static $appName;
		
		private $bootstrapPath;

		public function __construct(string $bootstrapPath)
		{
			$this->setBootstrapPath($bootstrapPath);
		}

		public function start(Request $request)
		{
			$response = $request->send();
			$data = $response->result();
			$data->render();
		}

		public function bootstrap()
		{
			if (file_exists($this->getBootstrapPath() . 'bootstrap.php')) {
				require_once $this->getBootstrapPath() . 'bootstrap.php';

				return true;
			}
			return false;
		}

		protected function setBootstrapPath(string $bootstrapPath)
		{
			$this->bootstrapPath = $bootstrapPath;
		}

		protected function getBootstrapPath()
		{
			return $this->bootstrapPath;
		}

		public static function configAppName(string $appName)
		{
			static::$appName = $appName;
		}

		public function getAppName()
		{
			return static::$appName;
		}
	}