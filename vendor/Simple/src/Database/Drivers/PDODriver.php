<?php 
	namespace Simple\Database\Drivers;

	use PDO;

	abstract class PDODriver
	{
		private $driverConfigs;

		public function __construct(array $driverConfigs)
		{
			$this->setDriverConfigs($driverConfigs);
		}

		protected function setDriverConfigs(array $driverConfigs)
		{
			$this->driverConfigs = $driverConfigs;
		}

		protected function getDatabaseConfig(string $databaseName)
		{
			$config = find_array_values($databaseName, $this->driverConfigs);
			
			if ($config) {
				return $config;
			}
			return false;
		}

		protected function connect(array $configs)
		{
			if (isset($configs['dsn']) && isset($configs['user']) && 
				isset($configs['password'])
			) {
				try {
					return new PDO($configs['dsn'], $configs['user'], $configs['password']);
				}
				catch(PDOException $exception){
					return false;
				}
			}
			return false;
		}
	}