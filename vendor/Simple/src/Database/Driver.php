<?php 
	namespace Simple\Database; 

	use Simple\Util\Builder;

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
			$driverConfig = find_array_values($driverName, static::$driversConfigs);

			if (!empty($driverConfig)) {
				$driver = new Builder(Driver::NAMESPACE . $driverName, [$driverConfig]);

				$this->driver = $driver->getBuiltInstance();
			}
		}

		public function getDriver()
		{
			return $this->driver;
		}

		public static function configDrivers(array $driversConfigs)
		{
			static::$driversConfigs = $driversConfigs;
		}
	}