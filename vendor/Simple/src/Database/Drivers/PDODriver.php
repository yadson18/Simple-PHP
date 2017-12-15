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
					$pdo = new PDO($configs['dsn'], $configs['user'], $configs['password']);
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

					return $pdo;
				}
				catch(PDOException $exception){
					return false;
				}
			}
			return false;
		}
	}