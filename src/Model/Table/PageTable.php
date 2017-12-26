<?php 
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class PageTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('DatabaseType', 'Example');

			$this->setTable('TableName');

			$this->setPrimaryKey('id');

			$this->setBelongsTo('', []);
		}

		public function defaultValidator(Validator $validator)
		{
			return $validator;
		}
	}