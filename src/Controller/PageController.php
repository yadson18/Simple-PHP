<?php 
	namespace App\Controller;

	use Simple\ORM\TableRegistry;

	class PageController extends AppController
	{
		public function isAuthorized(string $method)
		{
			return $this->alowedMethods($method, ['home']);
		}

		public function home()
		{ 
			$this->setTitle('Welcome!');
		}
	}