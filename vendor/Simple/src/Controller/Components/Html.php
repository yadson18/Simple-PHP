<?php  
    namespace Simple\Controller\Components;

    // A classe Html é usada para retornar textos e tags HTML específicos.
	class Html
    {
        /* 
         * Este método retorna a tag script que carregará o Javascript na View.
         *
         *  (string) scriptName, nome do script que deverá ser retornado e carregado.
         */
		public function script(string $scriptName)
        {
      		return "<script type='text/javascript' src='/js/{$scriptName}'></script>";
    	}
        /* 
         * Este método retorna a tag link que carregará o documento Css na View.
         *  
         *  (string) cssName, nome da folha de estilo que deverá ser retornado e carregado.
         */
    	public function css(string $cssName)
        {
      		return "<link rel='stylesheet' type='text/css' href='/css/{$cssName}'>";
    	}
        /* 
         * Este método retorna a tag link que carregará o documento Less na View.
         *  
         *  (string) lessName, nome do arquivo less que deverá ser retornado e carregado.
         */
        public function less(string $lessName)
        {
            return "<link rel='stylesheet/less' type='text/css' href='/less/{$lessName}'/>";
        }
	}