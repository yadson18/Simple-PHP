<?php 
	namespace Simple\Database;

	use Simple\Database\Connection;

	class Query
	{
		private $connection;

		private $type = 'select';

		private $parts = [
			'select' => [],
			'update' => [],
			'delete' => [],
			'insert' => []
		];

		protected function mountQuery()
		{
			$query = '';
			$values = [];

			while ($this->parts[$this->type]) {
				$query .= ' ' . key($this->parts[$this->type]);
				$partQuery = array_shift($this->parts[$this->type]);

				if (is_array($partQuery)) {
					while ($partQuery) {
						$column = (is_string(key($partQuery))) ? key($partQuery) . ' ' : '';
						$value = array_shift($partQuery);

						if ($column) {
							if ($this->type === 'select') {
								$query .= ' ' . $column . '?';
								$values[] = $value;
							}
							else {
								$query .= ' ' . $column . ' :' . $column;
								$values[$column] = $value;
							}
						}
						else {
							$query .= ' ' . $value;
						}
					}
				}
				else {
					$query .= ' ' . $partQuery;
				}
			}

			return $query;
		}

		public function getAll()
		{
			return $this->mountQuery();
		}

		public function __construct(string $databaseType, string $databaseName)
		{
			$this->setConnection(new Connection($databaseType), $databaseName);
		}

		public function select(string $fields)
		{
			$this->parts['update']['select'] = $fields;
			$this->setQueryType('update');

			return $this;
		}

		public function from(string $tables)
		{
			$this->parts[$this->type]['from'] = $tables;

			return $this;
		}

		public function where(array $condition)
		{
			$this->parts[$this->type]['where'] = $condition;

			return $this;
		}

		protected function checkQueryType(array $types)
		{
			if (in_array($this->getQueryType(), $types)) {
				return true;
			}
			return false;
		}

		protected function getQueryType()
		{
			return $this->type;
		}

		protected function setQueryType(string $type)
		{
			$this->type = $type;
		}

		protected function setConnection(Connection $connection, string $databaseName)
		{
			$connection->connectDatabase($databaseName);

			if ($connection->on()) {
				$this->connection = $connection->getConnection();
			}
		}

		protected function getConnection()
		{
			return $this->connection;
		}
	}