<?php 
	namespace Simple\ORM;

	use Simple\ORM\Component\Validator\Validator;
	use Simple\ORM\Component\Query\Query;
	use Simple\ORM\Component\Query\Insert;
	use Simple\ORM\Component\Query\Select;
	use Simple\ORM\Component\Query\Delete;
	use Simple\ORM\Component\Query\Update;
	
	class QueryBuilder
	{
		private $Validator;
		private $Select;
		private $Insert;
		private $Delete;
		private $Update;

		public function __construct(string $dbType, string $dbName, string $entityName)
		{
			Query::initialize($dbType, $dbName, $entityName);
			$this->Select = new Select();
			$this->Insert = new Insert();
			$this->Delete = new Delete();
			$this->Update = new Update();
			$this->Validator = new Validator();
		}

		public function find(string $columnFilters)
		{
			if ($this->Select->setFilters($columnFilters) && Query::setType("select")) {
				return $this;
			}
			return false;
		}

		public function from(string $tableName)
		{
			if (
				(Query::typeIs("select") && $this->Select->setTable($tableName)) ||
				(Query::typeIs("delete") && $this->Delete->setTable($tableName)) ||
				(Query::typeIs("update") && $this->Update->setTable($tableName))
			) {
				return $this;
			}
			return false;
		}

		public function where(array $whereCondition)
		{
			if (
				(Query::typeIs("select") && $this->Select->setCondition($whereCondition)) ||
				(Query::typeIs("delete") && $this->Delete->setCondition($whereCondition)) ||
				(Query::typeIs("update") && $this->Update->setCondition($whereCondition))
			) {
				return $this;
			}
			return false;
		}
		
		public function orderBy(array $columnsToOrder)
		{
			if ($this->Select->setOrderBy($columnsToOrder) && Query::typeIs("select")) {
				return $this;
			}
			return false;
		}

		public function convertTo(string $returnTypeData)
		{
			if ($this->Select->setReturnType($returnTypeData) && Query::typeIs("select")) {
				return $this;
			}
			return false;
		}

		public function limit(int $limitNumber)
		{
			if ($this->Select->setLimit($limitNumber) && Query::typeIs("select")) {
				return $this;
			}
			return false;
		}

		public function insert(array $dataToInsert)
		{
			if ($this->Insert->setInsertQuery($dataToInsert) && Query::setType("insert")) {
				return $this;
			}
			return false;
		}

		public function into(string $tableName)
		{
			if ($this->Insert->setTable($tableName) && Query::setType("insert")) {
				return $this;
			}
			return false;
		}

		public function delete(){
			if (Query::setType("delete")) {
				return $this;
			}
			return false;
		}

		public function update(array $dataToUpdate)
		{
			if ($this->Update->setUpdateQuery($dataToUpdate) && Query::setType("update")) {
				return $this;
			}
			return false;
		}

		public function getResult()
		{
			if (Query::typeIs("select")) {
				return $this->Select->getResult();
			}
			else if (Query::typeIs("insert")) {
				return $this->Insert->getResult();
			}
			else if (Query::typeIs("delete")) {
				return $this->Delete->getResult();
			}
			else if (Query::typeIs("update")) {
				return $this->Update->getResult();
			}
		}
	}