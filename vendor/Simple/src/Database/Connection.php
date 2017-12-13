<?php 
	namespace Simple\Database;

	use Simple\Database\Driver;
	use PDO;

	class Connection
	{
		private $currentDriver;

		private $connection;

		public function __construct(string $driverName)
		{
			$this->setCurrentDriver(new Driver($driverName));
		}
		
		public function connectDatabase(string $databaseName)
		{
			if (is_callable([$this->getCurrentDriver(), 'connect'])) {
				$connection = $this->getCurrentDriver()->connect($databaseName);

				if ($connection) {
					$this->setConnection($connection);
				}
			}
		}

		public function on()
		{
			if ($this->getConnection()) {
				return true;
			}
			return false;
		}

		protected function setConnection(PDO $connection){
			$this->connection = $connection;
		}

		public function getConnection(){
			return $this->connection;
		}

		protected function setCurrentDriver(Driver $driver)
		{
			$this->currentDriver = $driver->use();
		}

		protected function getCurrentDriver()
		{
			return $this->currentDriver;
		}
	}