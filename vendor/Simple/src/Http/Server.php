<?php 
	namespace Simple\Http;

	class Server
	{
		private static $configs;

		private $app;

		public function __construct(Application $app)
		{
			$this->app = $app;
		}

		public static function setConfig(string $config)
		{
			static::$configs = $config;
		}
	}