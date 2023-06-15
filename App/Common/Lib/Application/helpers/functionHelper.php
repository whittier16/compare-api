<?php

/**
 * Checks if a string is json
 *
 * @param string $string string to be used
 * @return void
 */

function isJson($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}

/**
 * Converts from an object to an array including private and protected members
 * @param object $object object to be converted
 * @return array Converted object
 */
function objectToArray($obj) {
	$tmp = json_encode($obj);
	$new = json_decode($tmp, true);
	return $new;
}

/**
 * Converts from a string to an object including private and protected members
 * @param string $string string to be converted
 * @return array Converted string
 */
function stringToArray($string) {
	$new = json_decode($string, true);
	return $new;
}

/**
 * Responds with data about schema
 *
 * @method readJsonFromFile
 * @param  string $file
 * @return array
 */
function readJsonFromFile($file, $obj = NULL) {
	$json = '';
	if (realpath($file)) {
		if ($obj->getDI()->getConfig()->application->osFlag) {
			$file = realpath($file);
		}
		$json = json_decode(file_get_contents($file), true);

	}
	return $json;
}

/**
 * Gets last key-value pair
 *
 * @method getLastKeyValue
 * @param  array $array
 * @return array
 */
function getLastKeyValue($array){
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