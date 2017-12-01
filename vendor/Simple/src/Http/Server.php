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
			$this->getApp()->bootstrap()->start(new Request());
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