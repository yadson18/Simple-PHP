<?php 
	namespace Simple\Database; 

	use ReflectionClass;

	class Driver
	{
		const NAMESPACE = 'Simple\\Database\\Drivers\\';

		private static $driversConfigs;

		private $driver;

		public function __construct(string $driverName)
		{
			$this->setDriver($driverName);
		}

		protected function setDriver(string $driverName)
		{
			if ($this->canBeUsed($driverName)) {
				$reflection = new ReflectionClass(Driver::NAMESPACE . $driverName);
					
				$this->driver = $reflection->newInstance(
					find_array_values($driverName, static::$driversConfigs)
				);
			}
		}

		public function getDriver()
		{
			return $this->driver;
		}

		protected function canBeUsed(string $driverName)
		{
			$driver = Driver::NAMESPACE . $driverName;

			if (class_exists($driver) &&
				find_array_values($driverName, static::$driversConfigs)
			) {
				return true;
			}
			return false;
		}

		public static function configDrivers(array $driversConfigs)
		{
			static::$driversConfigs = $driversConfigs;
		}
	}