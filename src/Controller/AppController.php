<?php 
	namespace App\Controller;

	use Simple\Http\Request;

	abstract class AppController
	{
		public function initialize(Request $request)
		{
			$this->Request = $request;
		}
	}