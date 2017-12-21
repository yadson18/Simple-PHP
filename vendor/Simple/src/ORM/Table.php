<?php
	namespace Simple\ORM;
	
	use Simple\ORM\Interfaces\EntityInterface;
	use Simple\ORM\Components\QueryBuilder;
	use Simple\Util\Builder;

	abstract class Table
	{
		const ENTITY_NAMESPACE = 'App\\Model\\Entity\\';

		private $queryBuilder;
		
		private $belongsTo = [];

		private $table;
		
		private $primaryKey;

		public function newEntity()
		{
			$entity = new Builder($this->getEntityName());

			return $entity->getBuiltInstance();
		}

		public function patchEntity(EntityInterface $entity, array $data)
		{
			foreach ($data as $attribute => $value) {
				if (is_string($attribute)) {
					$entity->$attribute = $value;
				}
			}

			return $entity;
		}

		protected function getEntityName()
		{
			$entityName = replace(splitNamespace(get_class($this)), 'Table', '');

			return Table::ENTITY_NAMESPACE . $entityName;
		}

		protected function setDatabase(string $driverName, string $databaseName)
		{
			$entity = $this->newEntity();

			$this->queryBuilder = new QueryBuilder(
				$driverName, $databaseName, $this->getEntityName()
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
			if (isset($this->queryBuilder)) {
				if (!empty($fields) && !empty($this->getTable())) {
					return $this->queryBuilder->select($fields)
						->from($this->getTable());
				}
			}
			return false;
		}

		public function get(string $key)
		{
			if (isset($this->queryBuilder)) {
				if (!empty($key) && !empty($this->getTable())) {
					if ($key === 'all') {
						return $this->queryBuilder->select('*')
							->from($this->getTable())
							->fetch('all');
					}
					else if (!empty($this->getPrimaryKey())) {
						return $this->queryBuilder->select('*')
							->from($this->getTable())
							->where([$this->getPrimaryKey() . ' = ' => $key])
							->limit(1)
							->fetch('class');
					}
				}
			}
			return false;
		}

		public function save(EntityInterface $entity)
		{	
			if (isset($this->queryBuilder) && !empty($this->getTable())) {
				$primaryKey = $this->getPrimaryKey();

				if (isset($entity->$primaryKey)) {
					if (!$this->get($entity->$primaryKey)) {
						return $this->queryBuilder->insert($this->getTable())
							->values((array) $entity)
							->fetch('rowCount');
					}
					$primaryKeyValue = $entity->$primaryKey;
					unset($entity->$primaryKey);

					return $this->queryBuilder->update($this->getTable())
						->set((array) $entity)
						->where([$primaryKey . ' = ' => $primaryKeyValue])
						->fetch('rowCount');
				}
			}
			return false;
		}

		public function delete(EntityInterface $entity) 
		{
			if (isset($this->queryBuilder)) {
				$primaryKey = $this->getPrimaryKey();

				if (isset($entity->$primaryKey)) {
					return $this->queryBuilder->delete($this->getTable())
						->where([$primaryKey . ' = ' => $entity->$primaryKey])
						->fetch('rowCount');
				}
			}
			return false;
		}
	}