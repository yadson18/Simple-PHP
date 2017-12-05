<?php  
	namespace Simple\Controller\Components;
	
	class Flash
	{
		private $messageType;

		private $messageText;

		public function setMessage(string $messageType, string $messageText)
		{
			if (!empty($messageType) && !empty($messageText)) {
				$this->messageType = $messageType;
				$this->messageText = $messageText;
			}
		}

		public function showMessage()
		{
			ob_start();

			if (isset($this->messageType) && isset($this->messageText)) {
				$template = TEMPLATE . 'Elements' . DS . 'Flash' . DS . $this->messageType . '.php';

				if (file_exists($template)) {
					$message = $this->messageText;

					include $template;

					$this->clearMessage();
					return ob_get_clean();
				}
			}
		}

		public function clearMessage()
		{
			unset($this->messageType);
			unset($this->messageText);
		}

		public function error(string $messageText)
		{
			$this->setMessage("error", $messageText);
		}

		public function info(string $messageText)
		{
			$this->setMessage("info", $messageText);
		}

		public function success(string $messageText)
		{
			$this->setMessage("success", $messageText);
		}

		public function warning(string $messageText)
		{
			$this->setMessage("warning", $messageText);
		}
	}