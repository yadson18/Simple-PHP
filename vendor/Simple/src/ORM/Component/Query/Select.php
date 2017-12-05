<?php 
	namespace Simple\ORM\Component\Query;

	use \PDO;

	class Select extends Query
	{
		private $returnType = "array";
		private $filters;
		private $orderBy;
		private $limit;

		public function setOrderBy(array $columnsToOrder)
		{
			if (!empty($columnsToOrder)) {
				$order = "";

				foreach ($columnsToOrder as $column => $orderType) {
					if (is_string($column) && !is_array($orderType)) {
						$order .= " {$column} {$orderType},";
					} 
				}

				if (!empty($order)) {
					$this->orderBy = " ORDER BY".substr($order, 0, (strlen($order) - 1));

					return true;
				}
			}
			return false;
		}
		public function getOrderBy()
		{
			return $this->orderBy;
		}

		public function setFilters(string $columnFilters)
		{
			if (!empty($columnFilters)) {
				$this->filters = $columnFilters;

				return true;
			}
			return false;
		}
		public function getFilters()
		{
			return $this->filters;
		}

		public function setLimit(int $limitNumber)
		{
			if (!empty($limitNumber)) {
				$this->limit = " FIRST {$limitNumber}";

				return true;
			}
			return false;
		}
		public function getLimit()
		{
			return $this->limit;
		}

		public function setReturnType(string $returnTypeData)
		{
			$avaliableTypes = ["object", "array"];
			
			if (!empty($returnTypeData) && in_array($returnTypeData, $avaliableTypes)) {
				$this->returnType = $returnTypeData;

				return $this;
			}
			return false;
		}
		public function returnTypeIs(string $returnType)
		{
			if ($this->returnType === $returnType) {
				return true;
			}
			return false;
		}

		public function getResult()
		{
			if ($this->connected()) {
				$query = $this->getConnection()->prepare(
					"SELECT{$this->getLimit()} {$this->getFilters()} 
					FROM {$this->getTable()}
					{$this->getCondition()}{$this->getOrderBy()}"
				);

				if (!empty($this->getConditionValues())) {
					foreach ($this->getConditionValues() as $column => $value) {
						$query->bindValue(++$column, $value);
					}
				}

				$query->execute();
				if ($this->returnTypeIs("object")) {
					$query->setFetchMode(PDO::FETCH_CLASS, $this->getCurrentEntity());
					$result = $query->fetchAll();

					if (!empty($result)) {
						return $result[0];
					}
					return false;
				}
				else if ($this->returnTypeIs("array")) {
					$query->setFetchMode(PDO::FETCH_ASSOC);
					return $query->fetchAll();
				}
			}
			echo "Fail";
			exit();
		}
	}