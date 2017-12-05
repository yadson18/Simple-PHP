<?php  
    namespace Simple\Controller\Components;
    
    class Html
    {
        public function css(string $cssName)
        {
            if (is_file(CSS . $cssName)) {
      		    return '<link rel="stylesheet" type="text/css" href="/css/' . $cssName . '">';
            }
    	}

        public function script(string $scriptName)
        {
            if (is_file(JS . $scriptName)) {
                return '<script type="text/javascript" src="/js/' . $scriptName . '"></script>';
            }
        }

        public function less(string $lessName)
        {
            if (is_file(LESS . $lessName)) {
                return '<link rel="stylesheet/less" type="text/css" href="/less/' . $lessName . '"/>';
            }
        }
	}