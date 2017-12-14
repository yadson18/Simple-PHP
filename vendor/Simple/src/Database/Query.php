<?php 
	namespace Simple\Database;

	use Simple\Database\Connection;

	class Query
	{
		private static $queries = [
			'insert' => 'INSERT INTO %tables% (%columnsString%) VALUES(%values%)',
			'select' => 'SELECT %columns% FROM %tables%',
			'update' => 'UPDATE %tables% SET %columnsFormated%',
			'delete' => 'DELETE FROM %tables%',
			'where' => 'WHERE %condition%',
			'order by' => 'ORDER BY %order%'
		];
		
		private $connection;

		private $type = 'select';

		private $parts = [
			'insert' => [],
			'select' => [],
			'update' => [],
			'delete' => []
		];

		private $values = [];

		public function __construct(string $databaseType, string $databaseName)
		{
			$this->setConnection(new Connection($databaseType, $databaseName));
		}

		protected function setConnection(Connection $connection)
		{
			$this->connection = $connection->getConnection();
		}

		protected function getConnection()
		{
			return $this->connection;
		}

		public function getAll()
		{
			return $this->mountQuery();
		}

		public function insert(array $dataToInsert)
		{
			$this->setQueryType('insert');
			$this->setData('columnsString', $dataToInsert);

			return $this;
		}

		public function select(string $fields)
		{
			$this->setQueryType('select');
			$this->setData('columns', $fields);

			return $this;
		}

		public function update(array $dataToUpdate)
		{
			$this->setQueryType('update');
			$this->setData('columnsFormated', $dataToUpdate);

			return $this;
		}

		public function from(string $tables)
		{
			$this->setData('tables', $tables);
			
			return $this;
		}

		public function where(array $condition)
		{
			$this->setData('where', $condition);

			return $this;
		}

		protected function getQueryType()
		{
			return $this->type;
		}

		protected function setQueryType(string $type)
		{
			$this->type = $type;
		}

		protected function separateColAndVal(array $arrayColAndVal)
		{
			$stringColumns = '';
			$values = [];

			while ($arrayColAndVal) {
				$column = key($arrayColAndVal);
				$value = array_shift($arrayColAndVal);

				if (is_string($column)) {
					if ($this->getQueryType() === 'select') {
						$stringColumns .= ' ' . $column . ' ?';
						$values[] = $value;
					}
					else {
						$columnRemoveSignal = strstr($column, ' ', true); 

						if ($columnRemoveSignal) {
							$stringColumns .= ' ,' . $column . ' :' . $columnRemoveSignal;
							$values[$columnRemoveSignal] = $value;
						}	
					}
				}
				else {
					$stringColumns .= ' ' . $value;
				}
			}

			if (!empty($stringColumns) && !empty($values)) {
				return [
					'columns' => $stringColumns,
					'values' => $values
				];
			}
			return false;
		}

		protected function mountQuery()
		{
			if (isset(static::$queries[$this->getQueryType()]) &&
				isset($this->parts[$this->getQueryType()])
			) {
				$query = static::$queries[$this->getQueryType()];
				$queryData = $this->parts[$this->getQueryType()];

				while ($queryData) {
					$column = key($queryData);
					$value = array_shift($queryData);

					if (isset(static::$queries[$column])) {
						$clause = static::$queries[$column];

						if ($column === 'where') {
							$query .= ' ' . replace($clause, '%condition%', $value);
						}
					}
					else {
						$query = replace($query, '%' . $column . '%', $value);
					}
				}

				return [
					'query' => $query,
					'values' => $this->values
				];
			}
		}

		protected function setData(string $index, $value)
		{
			if (!isset($this->parts[$this->getQueryType()][$index]) &&
				!empty($value)
			) {
				if (is_array($value)) {
					$data = $this->separateColAndVal($value);
					
					if ($data) {
						switch ($index) {
							case 'columnsFormated':
								$valueToSet = substr($data['columns'], 2);
							break;
							case 'where':
								$valueToSet = substr(replace($data['columns'], ',', ''), 1);
							break;
							case 'columnsString':
								$valueToSet = substr(replace($data['columns'], ',', ''), 1);
							break;
						}
						$this->parts[$this->getQueryType()][$index] = $valueToSet;
						$this->values = array_merge($data['values']);

						return true;
					}
				}
				else {
					$this->parts[$this->getQueryType()][$index] = $value;

					return true;
				}
			}
			return false;
		}
	}