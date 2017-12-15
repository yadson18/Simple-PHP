<?php 
	namespace Simple\Database\Statement;

	use PDOStatement;
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

		public function compiled()
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

		protected function prepare(string $query)
		{
			try {
				$this->statement = $this->getPdo()->prepare($query);

				return true;
			}
			catch(PDOException $exception){
				return false;
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
				catch(PDOException $exception){
					return false;
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
				catch(PDOException $exception){
					return false;
				}
			}
			return false;
		} 

		protected function isPdoStatement($statement)
		{
			if ($statement instanceof PDOStatement) {
				return true;
			}
			return false;
		}

		protected function setPdo(PDO $pdo){
			$this->pdo = $pdo;
		}

		protected function getPdo(){
			return $this->pdo;
		}

		public function getStatement()
		{
			if ($this->statement instanceof PDOStatement) {
				return $this->statement;
			}
			return false;
		}
	}