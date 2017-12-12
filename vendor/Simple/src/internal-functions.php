<?php 
	function array_deep_search(array $keys, array $array)
	{
		while ($keys) {
			$key = array_shift($keys);

			if (array_key_exists($key, $array)) {
				return (sizeof($keys) === 0) 
					? $array[$key] 
					: array_deep_search($keys, $array[$key]);
			}
		}

	}

	function replaceRecursive(string $value, array $replaces)
	{
		while ($replaces) {
			$value = replace($value, key($replaces), array_shift($replaces));
		}

		return $value;
	}

	function replace(string $value, string $search, string $replace)
	{
		return str_replace($search, $replace, $value);
	}

	function find_array_values(string $keys, array $array)
	{
		return array_deep_search(explode('.', $keys), $array);
	}

	function debug($data)
	{
		echo "<pre id='debug-screen'>";
		var_dump($data);
		echo "</pre>";
	}

	function splitNamespace(string $namespace)
	{
		return explode('\\', $namespace);
	}

	function removeSpecialChars($string) 
	{
	    $string = str_replace(["á","à","â","ã","ä"], "a", $string);
	    $string = str_replace(["Á","À","Â","Ã","Ä"], "A", $string);
	    $string = str_replace(["é","è","ê"], "e", $string);
	    $string = str_replace(["É","È","Ê"], "E", $string);
	    $string = str_replace(["í","ì"], "i", $string);
	    $string = str_replace(["Í","Ì"], "I", $string);
	    $string = str_replace(["ó","ò","ô","õ","ö"], "o", $string);
	    $string = str_replace(["Ó","Ò","Ô","Õ","Ö"], "O", $string);
	    $string = str_replace(["ú","ù","ü"], "u", $string);
	    $string = str_replace(["Ú","Ù","Ü"], "U", $string);
	    $string = str_replace("ç", "c", $string);
	    $string = str_replace("Ç", "C", $string);
	    $string = str_replace([
	    	"[","]",">","<","}","{",")","(",":",";",",","!","?","*","%","~","^","`","@"
	    ], "", $string);
	    
	    return $string;
	}