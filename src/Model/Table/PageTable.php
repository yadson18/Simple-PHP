<?php 
	namespace App\Model\Table;

	use Simple\ORM\Table;

	class PageTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('Firebird', 'SRICASH');

			$this->setTable('CADASTRO');

			$this->setPrimaryKey('cod_cadastro');

			$this->setBelongsTo('', []);
		}
	}