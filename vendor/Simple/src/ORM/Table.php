<?php
	namespace Simple\ORM;
	
	use ReflectionClass;

	abstract class Table
	{
		const ENTITY_NAMESPACE = 'App\\Model\\Entity\\';

		private $databaseType;

		private $databaseName;
		
		private $belongsTo = [];

		private $table;
		
		private $primaryKey;

		public function newEntity()
		{
			$namespace = splitNamespace(get_class($this));
			$entityName = str_replace('Table', '', array_pop($namespace));

			$entityName = Table::ENTITY_NAMESPACE . $entityName;

			if (class_exists($entityName)) {
				$entity = new ReflectionClass($entityName);

				return $entity->newInstance();
			}
		}

		protected function setDatabase(string $databaseType, string $databaseName)
		{
			$this->setDatabaseType($databaseType);
			$this->setDatabaseName($databaseName);
		}

		protected function setBelongsTo(string $fieldName, array $options)
		{
			$this->belongsTo[$fieldName] = $options;
		}

		protected function getBelongsTo(string $fieldName)
		{	
			if (isset($this->belongsTo[$fieldName])) {
				return $this->belongsTo[$fieldName];
			}
			return false;
		}

		protected function setTable(string $table)
		{
			$this->table = $table;
		}

		protected function getTable()
		{
			return $this->table;
		}

		protected function setPrimaryKey(string $primaryKey)
		{
			$this->primaryKey = $primaryKey;
		}

		protected function getPrimaryKey()
		{
			return $this->primaryKey;
		}

		protected function setDatabaseType(string $databaseType){
			$this->databaseType = $databaseType;
		}

		protected function getDatabaseType(){
			return $this->databaseType;
		}

		protected function setDatabaseName(string $databaseName){
			$this->databaseName = $databaseName;
		}

		protected function getDatabaseName(){
			return $this->databaseName;
		}
	}