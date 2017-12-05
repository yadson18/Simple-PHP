<?php  
	namespace Simple\ORM\Component\Query;

	class Insert extends Query
	{
		private $columns;
		private $formatedColumns;
		private $columnsAndValues;

		public function setInsertQuery(array $dataToInsert)
		{
			if (!empty($dataToInsert)) {
				$columns = sprintf(",%s", implode(",", array_keys($dataToInsert)));
				$formatedColumns = sprintf(",:%s", implode(",:", array_keys($dataToInsert)));

				if (!empty($columns) && !empty($formatedColumns)) {
					$this->columns = substr($columns, 1);
					$this->formatedColumns = substr($formatedColumns, 1);
					$this->columnsAndValues = $dataToInsert;

					return true;
				}
				return false;
			}
		}

		public function getColumns()
		{
			return $this->columns;
		}

		public function getFormatedColumns()
		{
			return $this->formatedColumns;
		}

		public function getColumnsAndValues()
		{
			return $this->columnsAndValues;
		}

		public function getResult()
		{
			if ($this->connected() && !empty($this->getColumnsAndValues())) {
				$query = $this->getConnection()->prepare(
					"INSERT INTO {$this->getTable()}({$this->getColumns()}) 
					VALUES({$this->getFormatedColumns()})"
				);

				foreach ($this->getColumnsAndValues() as $column => $value) {
					$query->bindValue(":{$column}", $value);
				}

				$query->execute();
				return $query->rowCount();
			}
			echo "Fail";
			exit();
		}
	}