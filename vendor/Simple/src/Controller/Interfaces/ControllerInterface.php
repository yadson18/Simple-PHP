<?php 
	namespace Simple\Controller\Interfaces;

	use Simple\Http\Request;
	use Simple\View\View;

	interface ControllerInterface
	{
		public function initialize(Request $request, View $view);

		public function isAuthorized(string $method);
	}