<?php 
	namespace App\Model\Table;

	use Simple\ORM\Table;

	class PageTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('Firebird', 'SRICASH');

			$this->setTable('Page');

			$this->setPrimaryKey('id');

			$this->setBelongsTo('cod_id', []);
		}
	}