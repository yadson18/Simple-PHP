<?php 
	namespace Simple\Configurator;

	class Configurator
	{
		private static $Instance;

		private $appConfigs = [];

		private function __construct(){}

		public static function getInstance()
		{
			if (!isset(self::$Instance)) {
				self::$Instance = new Configurator();
			}
			return self::$Instance;
		}

		public function setConfig(string $configName, $config)
		{
			if (!empty($configName) && !is_numeric($configName)) {
				if (is_bool($config) || !empty($config)) {
					$this->appConfigs[$configName] = $config;
				
					return $this;
				}
			}
			return false;
		}

		public function getConfig(string $configName)
		{
			if (isset($this->appConfigs[$configName])) {
				return $this->appConfigs[$configName];
			}
			return false;
		}
	}