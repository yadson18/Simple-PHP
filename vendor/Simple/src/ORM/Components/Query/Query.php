<?php  
	namespace Simple\ORM\Component\Query;
	
	use Simple\ORM\Component\PDO\Connection;

	abstract class Query
	{
		private static $Connection;
		private static $currentEntity;
		private static $queryType;
		private $table;
		private $condition;
		private $conditionValues;

		public static function initialize(string $dbType, string $dbName, string $entityName)
		{
			if (!empty($dbType) && !empty($dbName) && !empty($entityName)) {
				self::$Connection = new Connection($dbType, $dbName);
				self::$currentEntity = $entityName;
			}
		}

		public function getCurrentEntity()
		{
			return self::$currentEntity;
		}

		public function connected()
		{
			if (isset(self::$Connection)) {
				return true;
			}
			return false;
		}

		public function getConnection()
		{
			return self::$Connection->getConnection();
		}

		public static function typeIs(string $queryType)
		{
			if (self::$queryType === $queryType) {
				return true;
			}
			return false;
		}
		public static function setType(string $queryType)
		{
			if (!empty($queryType)) {
				self::$queryType = $queryType;

				return true;
			}
			return false;
		}

		public function setTable(string $tableName)
		{
			if (!empty($tableName)) {
				$this->table = $tableName;

				return true;
			}
			return false;
		}
		public function getTable()
		{
			return $this->table;
		}

		public function setCondition(array $queryCondition)
		{
			if (!empty($queryCondition)) {
				$condition = "";
				$values = [];

				foreach ($queryCondition as $column => $value) {
					if (is_string($column)) {
						if (self::typeIs("update")) {
							$removeSignal = substr($column, 0, (strlen($column) - 2));
							
							$condition .= " {$column} :{$removeSignal}";
							$values[$removeSignal] = $value;
						}
						else {
							$condition .= " {$column} ?";
							$values[] = $value;
						}
					}
					else {
						$condition .= " {$value}";
					}
				}

				if (!empty($condition)) {
					if (!empty($values)) {
						$this->conditionValues = $values;
					}
					$this->condition = " WHERE{$condition}";

					return true;
				}
				return false;
			}
		}

		public function getCondition()
		{
			return $this->condition;
		}
		public function getConditionValues()
		{
			return $this->conditionValues;
		}
	}