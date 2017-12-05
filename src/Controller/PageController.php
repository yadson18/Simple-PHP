<?php 
	namespace App\Controller;

	class PageController extends AppController
	{
		public function isAuthorized(string $method)
		{
			return true;
		}

		public function home()
		{ 
			
		}
	}