<?php 
	namespace Simple\ORM\Component\Query;

	class Delete extends Query
	{
		public function getResult()
		{
			if ($this->connected()) {
				$query = $this->getConnection()->prepare(
					"DELETE FROM {$this->getTable()}{$this->getCondition()}"
				);

				if (!empty($this->getConditionValues())) {
					foreach ($this->getConditionValues() as $column => $value) {
						$query->bindValue(++$column, $value);
					}
				}

				$query->execute();
				return $query->rowCount();
			}
			echo "Fail";
			exit();
		}
	}