<?php 
	namespace Simple\ORM\Component\Validator;

	class Validator
	{
		private $rules = [];

		protected function getLastKeyRule()
		{
			end($this->rules);
            return key($this->rules);
		}

		public function getRules()
		{
			return $this->rules;
		}

		public function addRule(string $column)
		{
			$this->rules[$column] = [];

			return $this;
		}

		public function notEmpty()
		{
			$this->rules[$this->getLastKeyRule()]["null"] = false;

			return $this;
		}
		public function empty()
		{
			$this->rules[$this->getLastKeyRule()]["null"] = true;

			return $this;
		}

		public function integer()
		{
			$this->rules[$this->getLastKeyRule()]["type"] = "integer";

			return $this;
		}
		public function string()
		{
			$this->rules[$this->getLastKeyRule()]["type"] = "string";

			return $this;
		}
		public function float()
		{
			$this->rules[$this->getLastKeyRule()]["type"] = "float";

			return $this;
		}
		public function double()
		{
			$this->rules[$this->getLastKeyRule()]["type"] = "double";

			return $this;
		}
		public function unknown()
		{
			$this->rules[$this->getLastKeyRule()]["type"] = "unknown";

			return $this;
		}

		public function size(int $size)
		{
			$this->rules[$this->getLastKeyRule()]["size"] = $size;

			return $this;
		}

		public function defaultValue($value)
		{
			$this->rules[$this->getLastKeyRule()]["defaultValue"] = $value;
		}
	}