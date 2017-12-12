<?php
    namespace Simple\View\Components;
    
    class Form
    {
        private static $defaultOptions = [
            'form' => [
                'method' => 'POST'
            ],
            'input' => [
                'type' => 'text', 'class' => 'form-control'
            ],
            'button' => [
                'type' => 'submit', 'class' => 'btn btn-default', 
            ]
        ];

        public function input(string $labelName, array $options = [])
        {
            $options = $this->mergeOptions('input', $options);
            if (!isset($options['name'])) {
                $options['name'] = strtolower($labelName);
            }
            if (!isset($options['id'])) {
                $options['id'] = strtolower($labelName);
            }

            return $this->div(
                $this->mountBlock([
                    $this->label($labelName), '<input' . $this->mountOptions($options) . '/>'
                ])
            );
        }

        public function button(string $buttonName, array $options = [])
        {
            $options = $this->mergeOptions('button', $options);
            if (!isset($options['id'])) {
                $options['id'] = strtolower($buttonName);
            }

            return $this->div(
                '<button' . $this->mountOptions($options) . '>' . $buttonName . '</button>'
            );
        }

        public function start(array $options = [])
        {
            return '<form' . $this->mountOptions($this->mergeOptions('form', $options)) . '>';
        }

        public function end()
        {
            return '</form>';
        }

        protected function label(string $name)
        {
            return '<label>' . $name . '</label>';
        }

        protected function div(string $elements)
        {
            return '<div class="form-group">' . $elements . '</div>';
        }

        protected function mergeOptions(string $elementName, array $options)
        {
            return array_merge($this->getDefaultOptions($elementName), $options);
        }

        protected function mountOptions(array $options)
        {
            $elementOptions = '';

            foreach ($options as $attribute => $value) {
                $elementOptions .= ' ' . $attribute . '="' . $value . '"';
            }
            return $elementOptions;
        }

        protected function mountBlock(array $blocks)
        {
            return implode($blocks);
        }
        
        protected function getDefaultOptions(string $elementName)
        {
            if (isset(static::$defaultOptions[$elementName])) {
                return static::$defaultOptions[$elementName];
            }
        }
    }