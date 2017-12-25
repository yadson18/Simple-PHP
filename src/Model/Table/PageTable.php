<?php 
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
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

		public function defaultValidator(Validator $validator)
		{
			$validator->addRule('cod_cadastro')->notEmpty()->integer()->size(5);

			return $validator;
		}
	}