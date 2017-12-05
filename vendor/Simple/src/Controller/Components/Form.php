<?php
    namespace Simple\Controller\Components;
    
    class Form
    {
        private $avaliableAttributes = [
            "input" => [
                "class", "id", "name", "placeholder", "required",
                "type" => [
                    "number", "date", "datetime", "time", "text", "radio", 
                    "checkbox", "submit", "button", "color", "password", "textarea"
                ]
            ],
            "button" => [
                "class", "id", "type" => ["submit", "button"]
            ]
        ];

        protected function getAvaliableAtts(string $tagName)
        {
            if (isset($this->avaliableAttributes[$tagName])) {
                return $this->avaliableAttributes[$tagName];
            }
        }

        protected function getTagAttributes(string $tagName, array $attributes = null, string $labelName = null)
        {
            if (!empty($tagName)) {
                $avaliableAttrs = $this->getAvaliableAtts($tagName);
                $tagAttributes = [];

                if (!empty($attributes)) {
                    foreach ($attributes as $attribute => $value) {
                        if (is_string($attribute)) {
                            if (in_array($attribute, $avaliableAttrs)) {
                                $tagAttributes[$attribute] = $value;
                            }
                            else if (isset($avaliableAttrs[$attribute])) {
                                if (in_array($value, $avaliableAttrs[$attribute])) {
                                    $tagAttributes[$attribute] = $value;
                                }
                            }
                        }
                        else {
                            $tagAttributes[$value] = "";
                        }
                    }
                }

                if ($tagName === "input" || $tagName === "select" || $tagName === "button") {
                    if (!array_key_exists("class", $tagAttributes)) {
                        $tagAttributes["class"] = "form-control ".strtolower(removeSpecialChars($labelName));
                        
                        if ($tagName === "button") {
                            $tagAttributes["class"] .= " btn btn-default";
                        }
                    }
                    if ($tagName === "input" || $tagName === "select") {
                        if (!array_key_exists("name", $tagAttributes)) {
                            $tagAttributes["name"] = strtolower(removeSpecialChars($labelName));
                        }
                    }
                }

                $stringAttributes = "";
                foreach($tagAttributes as $attribute => $value){
                    $stringAttributes .= " {$attribute}='{$value}'";
                }

                return $stringAttributes;
            }
            return false;
        }

        public function start(array $config)
        {
            $form = "<form";

            foreach ($config as $attribute => $value) {
                $form.= " {$attribute}='{$value}'";
            }

            return "{$form}>";
        }

        public function end()
        {
            return "</form>";
        }

        public function input(string $name, array $attributes = null)
        {
            if (!empty($name)) {
                $inputAttributes = $this->getTagAttributes("input", $attributes, $name);
                
                if (!empty($inputAttributes)) {
                    return "
                        <div class='form-group'>
                            <label>{$name}</label>
                            <input {$inputAttributes}/>
                        </div>
                    ";
                }
            }
        }

        public function buttonSubmit(string $text, array $attributes = null)
        {
            if (!empty($text)) {
                $buttonAttributes = $this->getTagAttributes("button", $attributes);
                
                if (!empty($buttonAttributes)) {
                    return "
                        <div class='form-group'>
                            <button {$buttonAttributes}>{$text}</button>
                        </div>
                    ";
                }
            }
        }
    }