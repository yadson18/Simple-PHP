<?php 
	namespace Simple\ORM;

	use ReflectionClass;
	use ReflectionMethod;

	abstract class TableRegistry
	{
		const NAMESPACE = 'App\\Model\\Table\\'; 

		const SUFIX = 'Table';

		public static function get(string $tableName)
		{
			return static::getTableInstance($tableName);
		}

		protected function getTableInstance(string $tableName)
		{
			$tableName = TableRegistry::NAMESPACE . $tableName . TableRegistry::SUFIX;

			if (class_exists($tableName)) {
				$reflectionTable = new ReflectionClass($tableName);
				$table = $reflectionTable->newInstance();
				
				if (is_callable([$table, 'initialize'])) {
					$reflectionMethod = new ReflectionMethod($tableName, 'initialize');
					$reflectionMethod->invoke($table);

					return $table;
				}
			}
		}
	}