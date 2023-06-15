<?php
namespace App\Common\Lib\Application\Controllers;

use App\Common\Lib\Application\Controllers\RESTController;

class MongodbQueryController extends RESTController{	
	
	protected $obj;
	
	public function __construct($params){
		$this->obj = $params;
	}
	
	/**
	 * Sets mongo operators
	 * @var array
	 */
	public $operators = array(
		'eq'   => '=',
		'ne'   => '$ne',
		'gt'   => '$gt',
		'gte'  => '$gte',
		'lte'  => '$lte',
		'lt'   => '$lt',
		'in'   => '$in',
		'nin'  => '$nin',
		'like' => 'LIKE',
		'distinct' => 'distinct'	
	);
	
	/**
	 * Gets columns to be returned
	 */
	public function partial () {
		$params = array();
		if ($this->obj->partialFields){
			foreach($this->obj->partialFields as $fields){
			   $params[$fields] = TRUE;
			}
		}
		return $params;
	}
	
	/**
	 * Sets the limit and offset
	 */
	public function limit () {
		$params = $this->obj->limit;
		
		if ($this->obj->offset){
			$params['limit'] = $this->obj->limit;
			$params['skip'] = $this->obj->offset;
		}
		return $params;
	}
	
	/**
	 * Sorts resultset
	 * @var array
	 */
	public function sort () {
		$condition = '';
		if ($this->obj->sortFields['unparsed']) {
			$sortFields = array_values($this->obj->sortFields['unparsed']);
			$lastValue = end($sortFields);
			foreach ($this->obj->sortFields['unparsed'] as $key => $fields){
				$index = 1;
				$fieldName = $fields;
				if ('-' == substr($fields, 0, 1)) {
					$index = -1;
					list(, $fieldName) = explode('-', $fields);
				}
				$condition[$fieldName] =  $index;
			}
		}
		return $condition;
	}
	
	/**
	 * Sets search conditions for finding resultsets
	 * @var array
	 */
	public function search ($id = NULL) {
		$condition = $condition2 = array();
		$relationalOperator = '';
		$searchId = '';
		
		if ($this->obj->searchFields['unparsed'] != NULL || $id != NULL) {
			$searchFields = $this->obj->searchFields['unparsed'];
			
			$last = getLastKeyValue($this->obj->searchFields['unparsed']); 
			if (!empty($last)) {
				$lastKey = $last['key'];
				$lastValue = $last['value'];
					
				foreach ($searchFields as $queries => $query){
					$operator = $queries;
					foreach ($query as $keys => $key) {
						foreach ($key as $field => $value) {
							$relationalOperator = '';
							if ('eq' == $operator) {
								$condition[$field] = $value;
							} else if ('like' == $operator) {
								$condition[$field] = new \MongoRegex("/$value/");
							} else if ('nin' == $operator || 'in' == $operator) {
								$value = !is_array($value) ? explode(",", trim($value,"()")) : $value;
								$condition[$field][$this->operators[$operator]] = $value;
							} else {
								$condition[$field][$this->operators[$operator]] = $value;
							}
						}
					}
				}
			}
		}
		
		if (NULL != $id) {
			$searchId['id'] = $id;
			$condition2 = $searchId;
		}
		
		$params = array_merge($condition, $condition2);
		
		return $params;
	}
	
	/**
	 * Get resultsets with the given query parameters
	 * @var array
	 */
	public function response($model, $id = 0) {
		$results = $params = array();
		$name = '';
		
		if ($this->obj->isPartial){
			$params['fields'] = $this->partial();
		}
		
		if ($this->obj->limit || $this->obj->limit != 0){
			$params['limit'] = $this->limit();
		}
		
		if ($this->obj->isSort){
			$params['order'] = $this->sort();
		}
		
		if ($this->obj->isSearch || $this->obj->language || $id != 0){
			$condition = $this->search($id);
			$language = array();
			$operator = '';
			
			if (get_class($model) == 'App\Modules\Frontend\Models\Products' ||
				get_class($model) == 'App\Modules\Frontend\Models\Companies' ||
				get_class($model) == 'App\Modules\Frontend\Models\Areas' || 
				get_class($model) == 'App\Modules\Frontend\Models\Brands'
				) {
				if (!empty($condition)){
					$operator = 'AND';
				}
				$language['language'] = $this->obj->language;
			}
			
			$conditions = array_merge($condition, $language);
			$params['conditions'] = $conditions;
		}
		
		$newObjs = $model::find($params);
		if (!empty($newObjs)){
			$newObjs = objectToArray($newObjs);
			foreach ($newObjs as $newObj) {
				$newObj['links']['rel'] = "self";				
				$newObj['links']['href'] = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REDIRECT_URL'] . $newObj['id'];
				$results[] = $newObj;
				
			}
		}
		
		return $results;
	}
}