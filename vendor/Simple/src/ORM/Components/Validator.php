<?php 
	namespace Simple\ORM\Components;

	class Validator 
	{
		private $rules = [];

		public function validateRule(string $ruleName, $value)
		{
			if (isset($this->rules[$ruleName])) {
				foreach ($this->rules[$ruleName] as $rule => $ruleValue) {
					switch ($rule) {
						case 'null':
							if (empty($value) && $ruleValue === false) {
								return false; 	
							} 
							break;
						case 'type':
							if (!empty($value)) {
								if (!eval("return is_{$ruleValue}(\$value);")) {
									return false;
								}
							}
							break;
						case 'size':
							if (strlen('' . ((string) $value)) > $ruleValue) {
								return false;
							}
							break;
					}
				}
			}
			return true;
		}

		public function addRule(string $ruleName)
		{
			$this->rules[$ruleName] = [];

			return $this;
		}

		public function notEmpty()
		{
			$this->addSubRule('null', false);

			return $this;
		}

		public function empty()
		{
			$this->addSubRule('null', true);

			return $this;
		}

		public function integer()
		{
			$this->addSubRule('type', 'integer');

			return $this;
		}

		public function string()
		{
			$this->addSubRule('type', 'string');

			return $this;
		}

		public function float()
		{
			$this->addSubRule('type', 'float');

			return $this;
		}

		public function double()
		{
			$this->addSubRule('type', 'double');

			return $this;
		}

		public function unknown()
		{
			$this->addSubRule('type', 'unknown');

			return $this;
		}

		public function size(int $size)
		{
			$this->addSubRule('size', $size);

			return $this;
		}

		protected function addSubRule(string $subRuleName, $data)
		{
			$this->rules[$this->getLastKey()][$subRuleName] = $data;
		}

		protected function getLastKey()
		{
			end($this->rules);
            return key($this->rules);
		}
	}