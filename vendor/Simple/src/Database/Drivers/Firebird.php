<?php 
	namespace Simple\Database\Drivers;

	use PDO;

	class Firebird
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

		public function connect(string $databaseName)
		{
			$config = $this->getDatabaseConfig($databaseName);

			if ($config) {
				$host = $config['host'];
				$path = $config['path'];
				$charset = $config['encoding'];

				$dsn = 'firebird:dbname=' . $host . ':' . $path . ';charset=' . $charset;
				$user = $config['user'];
				$password = $config['password'];

				try {
					return new PDO($dsn, $user, $password);
				}
				catch(PDOException $e){
					return null;
				}
			}
		}
	}	