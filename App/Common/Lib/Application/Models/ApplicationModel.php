<?php

namespace App\Common\Lib\Application\Models;

/**
 * Application model base class
 */
class ApplicationModel
{
	/**
	 * Gets last key-value pair
	 *
	 * @method getLastKeyValue
	 * @param  array $array
	 * @return array
	 */
	public function getLastKeyValue($array){
		$result = array();
		if ($array){
			$firstElement = array_pop($array);
			$secondElement = array_pop($firstElement);
	
			$lastArrayKey = array_keys($secondElement);
			$lastArrayValue = array_values($secondElement);
	
			$result['key'] = end($lastArrayKey);
			$result['value'] = end($lastArrayValue);
		}
		return $result;
	}
}
