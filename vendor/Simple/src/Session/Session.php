<?php 
	namespace Simple\Session;
	
	class Session
	{
		public function __construct()
		{
			session_start(['cookie_lifetime' => 86400]);
		}

		protected function startSession()
		{
			if (!isset($_SESSION['newSession'])) {
				$_SESSION = [
					'newSession' => [],
					'logged' => true,
					'created' => date('H:i')
				];
			}
		}

		protected function createNewId(int $minutes)
		{
			if (isset($_SESSION['newSession'])) {
				$time = 60 * $minutes;
				
				if ((strtotime(date('H:i')) - strtotime($_SESSION['created'])) >= $time) {
					session_regenerate_id(); 
					$_SESSION['created'] = date('H:i');
				}
			}
		}

		public function findData(string $index)
		{
			if (isset($_SESSION['newSession'][$index])) {
				return true;
			}
			return false;
		}

		public function removeData(string $index)
		{
			if (isset($_SESSION['newSession'][$index])) {
				unset($_SESSION['newSession'][$index]);
			}
			return false;
		}

		public function getData()
		{
			if (isset($_SESSION['newSession'])) {
				return array_map('unserialize', $_SESSION['newSession']);
			}
		}

		public function setData(string $index, $data)
		{
			$this->startSession();
			$this->createNewId(5);

			if (!empty($index) && !empty($data)) {
				$_SESSION['newSession'][$index] = serialize($data);
			}
		}

		public function close()
		{
			if (isset($_SESSION['newSession'])) {
				session_destroy();
			}
		}
	}