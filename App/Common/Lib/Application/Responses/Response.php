<?php
namespace App\Common\Lib\Application\Responses;

class Response extends \Phalcon\DI\Injectable{

	protected $head = false;

	public function __construct(){
		$di = \Phalcon\DI::getDefault();
		$this->setDI($di);
		if (strtolower($this->di->get('request')->getMethod()) === 'head'){
			$this->head = true;
		}
	}

	/**
	 * In-Place, recursive conversion of array keys in snake_Case to camelCase
	 * @param  array $snakeArray Array with snake_keys
	 * @return  no return value, array is edited in place
	 */
	protected function arrayKeysToSnake($snakeArray = array()){
		if (is_array($snakeArray)) {
			foreach($snakeArray as $k=>$v){
				if (is_array($v)){
					$v = $this->arrayKeysToSnake($v);
				}
				$snakeArray[$this->snakeToCamel($k)] = $v;
				if ($this->snakeToCamel($k) != $k){
					unset($snakeArray[$k]);
				}
			}
		}
		return $snakeArray;
	}

	/**
	 * Replaces underscores with spaces, uppercases the first letters of each word, 
	 * lowercases the very first letter, then strips the spaces
	 * @param string $val String to be converted
	 * @return string     Converted string
	 */
	protected function snakeToCamel($val) {
		return str_replace(' ', '', lcfirst(ucwords(str_replace('_', ' ', $val))));
	}
	
	/**
	 * Converts from associative array to xml
	 * @param array $array object to be converted
	 * @param string $node_name string to be used
	 * @return array Converted object
	 */
	function array2xml($array, $node_name="root") {
		$dom = new \DOMDocument('1.0', 'UTF-8');
		$dom->formatOutput = true;
		$root = $dom->createElement($node_name);
		$dom->appendChild($root);
	
		$array2xml = function ($node, $array) use ($dom, &$array2xml) {
			foreach ($array as $key => $values){
				if (is_array($values)) {
					foreach ($values as $key2 => $val ){
						$n = $dom->createElement($key2);
						$node->appendChild($n);
						$array2xml($n, $values);
					}
				}else{
					$attr = $dom->createAttribute($key);
					$attr->value = $values;
					$node->appendChild($attr);
				}
			}
		};
	
		$array2xml($root, $array);
	
		return $dom->saveXML();
	}
	
	
}
