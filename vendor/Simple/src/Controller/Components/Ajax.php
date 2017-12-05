<?php  
	namespace Simple\Controller\Components;
	
	class Ajax
	{
		private $response;

		public function response(array $data)
		{
			if (!empty($data)) {
				$this->response = $data;
			}
			else {
				$this->response = [
					'status' => 'error',
					'message' => 'Ajax response cannot be empty or resource type'
				];
			}
		}

		public function notEmptyResponse()
		{
			if (isset($this->response)) {
				return true;
			}
			return false;
		}

		public function getResponse()
		{
			return json_encode($this->response);
		}
	}
?>
