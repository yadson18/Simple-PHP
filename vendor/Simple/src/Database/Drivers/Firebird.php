<?php 
	namespace Simple\Database\Drivers;

	use Simple\Database\Drivers\PDODriver;

	class Firebird extends PDODriver
	{
		private static $dsn = 'firebird:dbname=%host%:%path%;charset=%encode%';

		public function __construct(array $driverConfigs)
		{
			parent::__construct($driverConfigs);
		}

		public function connectInto(string $databaseName)
		{
			$config = $this->getDatabaseConfig($databaseName);

			if ($config) {
				$connectionConfig = [
					'dsn' => replaceRecursive(static::$dsn, [
						'%host%' => $config['host'],
						'%path%' => $config['path'],
						'%encode%' => $config['encoding']
					]),
					'user' => $config['user'],
					'password' => $config['password']
				];

				return $this->connect($connectionConfig);
			}
		}
	}	