<?php 
	namespace Simple\Database;

	use Simple\Database\Driver;
	use PDO;

	class Connection
	{
		private $connection;

		public function __construct(string $driverName, string $databaseName)
		{
			$this->connect(new Driver($driverName), $databaseName);
		}

		protected function connect(Driver $driver, string $databaseName)
		{
			$driver = $driver->getDriver();

			if (is_callable([$driver, 'connectInto'])) {
				$this->setConnection($driver->connectInto($databaseName));
			}
		}

		protected function setConnection(PDO $connection){
			$this->connection = $connection;
		}

		public function getConnection(){
			return $this->connection;
		}
	}