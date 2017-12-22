<?php 
	namespace Simple\Database\Statement;

	use PDOStatement;
	use PDOException;
	use PDO;

	class Statement
	{
		private $statement;

		private $pdo;

		private $compiled = false;

		public function __construct(PDO $pdo)
		{
			$this->setPdo($pdo);
		}

		protected function compiled()
		{
			return $this->compiled;
		}

		public function compileQuery(string $queryType, string $query, array $values)
		{
			if ($this->getPdo() && !empty($query)) {
				if ($this->prepare($query)) {
					if (!empty($values) && $this->bind($queryType, $values)) {
						if ($this->execute()) {
							$this->compiled = true;
						}
					}
					else if ($this->execute()) {
						$this->compiled = true;
					}
				}
			}
		}

		public function rowCount()
		{
			if ($this->compiled()) {
				return $this->statement->rowCount();
			}
			return false;
		}

		public function fetchAll()
		{
			if ($this->compiled()) {
				return $this->statement->fetchAll(PDO::FETCH_ASSOC);
			}
			return false;
		}

		public function fetchObject($object = null)
		{
			if ($this->compiled()) {
				if (!empty($object)) {
					return $this->statement->fetchObject($object);
				}
				return $this->statement->fetchObject();
			}
			return false;
		}

		protected function prepare(string $query)
		{
			try {
				$this->statement = $this->getPdo()->prepare($query);

				return true;
			}
			catch (PDOException $exception) {
				echo $exception->getMessage();
			}
			return false;
		}

		protected function bind(string $queryType, array $values)
		{	
			if ($this->isPdoStatement($this->statement) && !empty($values)) {
				try {
					foreach ($values as $column => $value) {
						if ($queryType === 'select') {
							if (!$this->statement->bindValue(++$column, $value)) {
								return false;
							}
						}
						else if ($queryType !== 'select') {
							if (!$this->statement->bindValue(':' . $column, $value)) {
								return false;
							}
						}
						else {
							return true;
						}
					}
				}
				catch (PDOException $exception) {
					return $exception->getMessage();
				}
			}
			return false;
		}

		protected function execute()
		{
			if ($this->isPdoStatement($this->statement)) {
				try {
					$this->statement->execute();

					return true;
				}
				catch (PDOException $exception) {
					return $exception->getMessage();
				}
			}
			return false;
		} 

		protected function setPdo(PDO $pdo){
			$this->pdo = $pdo;
		}

		protected function getPdo(){
			return $this->pdo;
		}

		protected function isPdoStatement($statement)
		{
			if ($statement instanceof PDOStatement) {
				return true;
			}
			return false;
		}
	}