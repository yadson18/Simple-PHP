<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class %table_name%Table extends Table
	{
		public function initialize()
		{
			$this->setDatabase('%db_type%', '%db_name%');

			$this->setTable('%table%');

			$this->setPrimaryKey('%primary_key%');

			$this->setBelongsTo('', []);
		}

		public function defaultValidator(Validator $validator)
		{%table_attributes%

			return $validator;
		}
	}