<?php 
	namespace Simple\Http;

	use Simple\Application\Application;
	use Simple\Configurator\Configurator;

	class Server
	{
		private $app;

		public function __construct(Application $app)
		{
			$this->setApp($app);
		}

		public function run()
		{
			$this->getApp()->bootstrap()
				->start(new Request($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']));
		}

		public function setApp(Application $app)
		{
			$this->app = $app;
		}

		public function getApp()
		{
			return $this->app;
		}
	}