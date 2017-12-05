<?php 
	namespace App\Controller;

	use Simple\Controller\Controller;
	use Simple\Http\Request;

	abstract class AppController extends Controller
	{
		public function initialize(Request $request)
		{
			parent::initialize($request);

			$this->loadComponent('Ajax');

			$this->loadComponent('Html');
		}	
	}