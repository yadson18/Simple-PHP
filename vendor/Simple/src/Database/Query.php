<?php 
	namespace Simple\Database;

	use Simple\Database\Connection;

	class Query
	{
		private $connection;

		private $type = 'select';

		private $query;

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

		public function select(string $fields)
		{
			$this->setQueryType('select');
			$this->concat('SELECT ' . $fields);

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

			$this->concat('(' . $columns . ')');
			$this->concat('VALUES (' . $columnsFormated . ')');

			return $this;
		}

		public function insertInto(string $table)
		{
			$this->setQueryType('insert');
			$this->concat('INSERT INTO ' . $table);

			return $this;
		}

		public function delete()
		{
			$this->setQueryType('delete');
			$this->concat('DELETE');

			return $this;
		}

		public function from(string $tables)
		{
			$this->concat('FROM ' . $tables);

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

			$this->concat('WHERE' . $conditionString);

			return $this;
		}

		protected function concat(string $query)
		{
			$this->query .= ' ' . $query;
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