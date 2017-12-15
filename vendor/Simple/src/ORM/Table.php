<?php
	namespace Simple\ORM;
	
	use Simple\ORM\Interfaces\EntityInterface;
	use Simple\ORM\Components\QueryBuilder;
	use Simple\Util\Builder;

	abstract class Table
	{
		const ENTITY_NAMESPACE = 'App\\Model\\Entity\\';

		private $databaseType;

		private $databaseName;

		private $queryBuilder;
		
		private $belongsTo = [];

		private $table;
		
		private $primaryKey;

		public function newEntity()
		{
			$entity = new Builder($this->getEntityName());

			return $entity->getBuiltInstance();
		}

		protected function getEntityName()
		{
			$entityName = replace(splitNamespace(get_class($this)), 'Table', '');

			return Table::ENTITY_NAMESPACE . $entityName;
		}

		protected function setDatabase(string $databaseType, string $databaseName)
		{
			$entity = $this->newEntity();

			$this->queryBuilder = new QueryBuilder(
				$databaseType, $databaseName, $this->getEntityName()
			);
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

		public function find(string $fields)
		{
			if (isset($this->queryBuilder) && !empty($fields)) {
				return $this->queryBuilder->select($fields)
					->from($this->getTable());
			}
		}

		public function get(string $key)
		{
			if (isset($this->queryBuilder) && !empty($key)) {
				if ($key === 'all') {
					return $this->queryBuilder->select('*')
						->from($this->getTable())
						->fetch('all');
				}
				return $this->queryBuilder->select('*')
					->from($this->getTable())
					->where([$this->getPrimaryKey() . ' =' => $key])
					->limit(1)
					->fetch('class');
			}
		}

		public function set(EntityInterface $entity)
		{	
			if (isset($this->queryBuilder) && isset($entity)) {
				return $this->queryBuilder->insert($this->getTable())
					->values((array) $entity)
					->fetch('rowCount');
			}
		}
	}