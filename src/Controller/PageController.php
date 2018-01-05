<?php 
	namespace App\Controller;

	class PageController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow(['home']);
		}

		public function home()
		{ 
			$this->setTitle('Welcome!');

			$this->Auth->setUser($this->Page->newEntity());	
		}
	}