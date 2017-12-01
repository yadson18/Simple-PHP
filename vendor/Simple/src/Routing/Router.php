<?php 
	namespace Simple\Routing;

	class Router
	{
		private static $defaultRoute;

		public static function configRoute(array $defaultRoute)
		{
			static::$defaultRoute = $defaultRoute;
		}

		public static function getDefaultRoute(string $indexName = null)
		{	
			if (!empty($indexName)) {
				if (isset(static::$defaultRoute[$indexName])) {
					return static::$defaultRoute[$indexName];
				}
				return false;
			}
			return static::$defaultRoute;
		}
	}