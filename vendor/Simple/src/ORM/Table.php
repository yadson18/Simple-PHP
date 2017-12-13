<?php
	namespace Simple\ORM;
	
	use Simple\Util\Builder;

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
			$entityName = replace(splitNamespace(get_class($this)), 'Table', '');
			$entity = new Builder(Table::ENTITY_NAMESPACE . $entityName);

			return $entity->getBuiltInstance();
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