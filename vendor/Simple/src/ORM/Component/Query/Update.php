<?php  
	namespace Simple\ORM\Component\Query;

	class Update extends Query
	{
		private $columns;
		private $formatedColumns;
		private $columnsAndValues;

		public function setUpdateQuery(array $dataToUpdate)
		{
			if (!empty($dataToUpdate)) {
				$formatedColumns = "";

				foreach (array_keys($dataToUpdate) as $column) {
					$formatedColumns .= ", {$column} = :{$column}";
				}

				if (!empty($formatedColumns)) {
					$this->formatedColumns = substr($formatedColumns, 1);
					$this->columnsAndValues = $dataToUpdate;

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
			if ($this->connected()) {
				$query = $this->getConnection()->prepare(
					"UPDATE {$this->getTable()} SET {$this->getFormatedColumns()}{$this->getCondition()}"
				);

				$columnsAndValues = array_merge($this->getColumnsAndValues(), $this->getConditionValues());
				
				foreach ($columnsAndValues as $column => $value) {
					$query->bindValue(":{$column}", $value);
				}

				$query->execute();
				return $query->rowCount();
			}
			echo "Fail";
			exit();
		}
	}