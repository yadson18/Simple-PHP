<?php 
	namespace App\Model\Table;

	use Simple\ORM\Table;

	class PageTable extends Table
	{
		public function __construct()
		{
			parent::__construct('Firebird', 'SRICASH');
		}
		
		public function initialize()
		{
			$this->setTable('CADASTRO');

			$this->setPrimaryKey('cod_cadastro');

			$this->setBelongsTo('', []);
		}
	}