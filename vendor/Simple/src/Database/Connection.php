<?php 
	namespace Simple\Database;

	use Simple\Database\Driver;

	class Connection
	{
		private $driver;

		public function __construct(string $driverName)
		{
			$this->setDriver($driverName);
		}

		protected function setDriver(string $driverName)
		{
			$driver = new Driver($driverName);

			if (!empty($driver)) {
				$this->driver = $driver->getDriver();
			}
		}

		protected function getDriver()
		{
			if (isset($this->driver)) {
				return $this->driver;
			}
		}

		public function connectInto(string $databaseName)
		{
			if ($this->getDriver()) {
				return $this->getDriver()->connect($databaseName);
			}
		}
	}