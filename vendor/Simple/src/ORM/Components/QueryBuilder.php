<?php 
	namespace Simple\ORM\Components;

	use Simple\ORM\Component\Validator\Validator;
	use Simple\Database\Statement\Statement;
	use Simple\Database\Connection;
	
	class QueryBuilder
	{
		private $entity;

        private $connection;

		private $type = 'select';

		private $query = [];

		private $values = [];

		public function __construct(string $driverName, string $databaseName, string $entity)
		{
			$this->setConnection(new Connection($driverName, $databaseName));
			$this->setEntity($entity);
		}

		protected function setConnection(Connection $connection)
		{
			$this->connection = $connection->getConnection();
		}

		protected function getConnection()
		{
			return $this->connection;
		}

		public function select(string $fields)
		{
			$this->setQueryType('select');
			$this->concat('fields', ' ' . $fields);

			return $this;
		}

		public function count(string $field)
		{
			$this->concat('count', '(' . $field . ')');

			return $this;
		}

		public function first(int $quantity)
		{
			$this->concat('first', ' ' . $quantity);

			return $this;
		}

		public function limit(int $quantity)
		{
			$this->first($quantity);

			return $this;
		}

		public function skip(int $skipTo)
		{
			$this->concat('skip', ' ' . $skipTo);

			return $this;
		}

		public function orderBy(array $order)
		{
			$orderString = '';

			while ($order) {
				$column = key($order);
				$orderType = array_shift($order);

				if (is_string($column)) {
					$orderString .= ' ,' . $column . ' ' . $orderType;
				}
				else {
					$orderString .= ' ,' . $orderType;
				}
			}

			$this->concat('order by', ' ' . substr($orderString, 2));

			return $this;
		}

		public function groupBy(string $fields)
		{
			$this->concat('group by', ' ' . $fields);

			return $this;
		}

		public function values(array $dataToInsert)
		{
			$columns = implode(', ', array_keys($dataToInsert));
			$columnsFormated = ':' . implode(', :', array_keys($dataToInsert));

			while ($dataToInsert) {
				$column = key($dataToInsert);
				$value = array_shift($dataToInsert);

				if (is_string($column)) {
					$this->values[$column] = $value;
				}
			}

			$this->concat('values', '(' . $columnsFormated . ')');

			return $this;
		}

		public function insert(string $table)
		{
			$this->setQueryType('insert');
			$this->concat('into', ' ' . $table);

			return $this;
		}

		public function delete(string $table)
		{
			$this->setQueryType('delete');
			$this->concat('from', ' ' . $table);

			return $this;
		}

		public function from(string $tables)
		{
			$this->concat('from', ' ' . $tables);

			return $this;
		}

		public function update(string $table)
		{
			$this->setQueryType('update');
			$this->concat('table', ' ' . $table);

			return $this;
		}

		public function set(array $valuesTuUpdate)
		{
			$columnsString = '';

			while ($valuesTuUpdate) {
				$column = key($valuesTuUpdate);
				$value = array_shift($valuesTuUpdate);

				if (is_string($column)) {
					$columnsString .= ' ,' . $column . ' = :' . $column;
					$this->values[$column] = $value; 
				}
			}

			$this->concat('set', ' ' . substr($columnsString, 2));

			return $this;
		}

		public function where(array $condition)
		{
			$conditionString = '';

			while ($condition) {
				$column = key($condition);
				$value = array_shift($condition);

				if (is_string($column)) {
					if ($this->getQueryType() === 'select') {
						$conditionString .= ' ' . $column . ' ?'; 
						$this->values[] = $value;
					}
					else {
						$columnRemoveSignal = strstr($column, ' ', true);
						
						$conditionString .= ' ' . $column . ' :' . $columnRemoveSignal;
						$this->values[$columnRemoveSignal] = $value;
					}
				}
				else {
					$conditionString .= ' ' . $value;
				}
			}

			$this->concat('where', $conditionString);

			return $this;
		}

		public function whereNotExists(string $query)
		{
			$this->concat('where not exists', ' (' . $query . ')');

			return $this;
		}

		public function fetch(string $fetchType = null)
		{
			$query = $this->mountQuery();

			if ($query && $query->compiled()) {
				$statement = $query->getStatement();

				switch ($fetchType) {
					case 'all':
						return $statement->fetchAll();
						break;
					case 'object':
						return $statement->fetchObject();
						break;
					case 'class':
						if (class_exists($this->getEntity())) {
							return $statement->fetchObject($this->getEntity());
						}
						break;
					case 'rowCount':
						return $statement->rowCount();
						break;
					default:
						return $statement->fetchAll();
						break;
				}
			}
			return false;
		}

		protected function setEntity(string $entity)
		{
			$this->entity = $entity;
		}

		protected function getEntity()
		{
			return $this->entity;
		}

		protected function mountQuery()
		{
			switch ($this->getQueryType()) {
				case 'select':
					$order = [
						'first', 'skip', 'count', 'fields', 'from', 'where', 'group by', 'order by'
					];
					break;
				case 'insert':
					$order = ['into', 'values', 'where not exists'];
					break;
				case 'delete':
					$order = ['from', 'where'];
					break;
				case 'update':
					$order = ['table', 'set', 'where'];
					break;
			}

			$statement = new Statement($this->getConnection());
			$statement->compileQuery(
				$this->getQueryType(), $this->mountQueryByOrder($order), $this->values
			);
			$this->resetToDefault();

			return $statement;
		}

		protected function mountQueryByOrder(array $order)
		{
			$query = $this->getQueryType();

			foreach ($order as $identifier) {
				if (isset($this->query[$this->getQueryType()][$identifier])) {
					if ($identifier !== 'fields' && $identifier !== 'table') {
						$query .= ' ' . $identifier;
					}

					$query .= $this->query[$this->getQueryType()][$identifier];
				}
			}

			return $query;
		}

		protected function resetToDefault()
		{
			unset($this->query[$this->getQueryType()]);
			$this->values = [];
		}

		protected function concat(string $identifier, string $query)
		{
			$this->query[$this->getQueryType()][$identifier] = $query;
		}

		protected function setQueryType(string $type)
		{
			$this->type = $type;
		}

		protected function getQueryType()
		{
			return $this->type;
		}
	}