<?php 
	abstract class Autoload
	{	
		public static function loadNameSpaces()
		{
            spl_autoload_register( function($namespace) {
            	self::fromVendorDir($namespace);
            	self::fromAppDir($namespace);
            });
        }

        protected function config(string $prefix, string $baseDir, string $namespace)
        {
        	$size = strlen($prefix);

        	if (strncmp($prefix, $namespace, $size) !== 0) {
        		return;
        	}
			
			$relativeClass = substr($namespace, $size);
			
			$pathToClass = $baseDir . str_replace('\\', DS, $relativeClass) . '.php';
			
			if (file_exists($pathToClass)) {
        		require_once $pathToClass;
        	}
        }

        protected function fromVendorDir($namespace)
        {
        	self::config('Simple\\', SIMPLE, $namespace);
        }

        protected function fromAppDir($namespace)
        {
        	self::config('App\\', APP, $namespace);
        }
	}