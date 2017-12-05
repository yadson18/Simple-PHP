<?php 
	namespace App\Controller;

	use Simple\Controller\Controller;
	use Simple\Http\Request;
	use Simple\View\View;

	abstract class AppController extends Controller
	{
		public function initialize(Request $request, View $view)
		{
			parent::initialize($request, $view);

			$this->loadComponent('Ajax');

			$this->loadComponent('Flash');
		}	

		protected function alowedMethods(string $method, array $methods)
        {
            if (in_array($method, $methods)) {
                return true;
            }
            return false;
        }
	}