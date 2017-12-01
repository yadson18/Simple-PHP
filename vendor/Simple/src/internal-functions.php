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

	function find_array_values(string $keys, array $array)
	{
		return array_deep_search(explode('.', $keys), $array);
	}