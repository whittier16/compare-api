<?php
namespace App\Common\Lib\Application\Controllers;

use App\Common\Lib\Application\Controllers\RESTController;


class MysqlQueryController extends RESTController{	
	
	protected $obj;
	
	public function __construct($params){
		$this->obj = $params;
	}
	
	/**
	 * Sets mysql operators
	 * @var array
	 */
	public $operators = array(
		'eq'   => '=',
		'ne'   => '!=',
		'gt'   => '$',
		'gte'  => '>=',
		'lte'  => '<=',
		'lt'   => '<',
		'in'   => 'IN',
		'like' => 'LIKE',
		'nin'  => 'NOT IN'
	);
	
	/**
	 * Gets columns to be returned
	 * @method partial
	 * @return array
	 */
	public function partial () {
		$params = $this->obj->partialFields;
		return $params;
	}
	
	/**
	 * Sets the limit and offset
	 * @method limit
	 * @return array
	 */
	public function limit () {
		$params = $this->obj->limit;
		
		if ($this->offset){
			$params['number'] = $this->obj->limit;
			$params['offset'] = $this->obj->offset;
		}
		return $params;
	}
	
	/**
	 * Sorts resultset
	 * @method sort
	 * @return string
	 */
	public function sort () {
		$condition = '';
		if ($this->obj->sortFields['unparsed']) {
			$sortFields = array_values($this->obj->sortFields['unparsed']);
			$lastValue = end($sortFields);
			foreach ($this->obj->sortFields['unparsed'] as $key => $fields){
				$clause = '';
				$separator = '';
				if ('-' == substr($fields, 0, 1)) {
					$clause = 'DESC';
					list(, $fieldName) = explode('-', $fields);
				}else{
					$fieldName = $fields;
				}
					
				if (count($this->obj->sortFields['unparsed']) > 1 && $lastValue != $fields) {
					$separator = ', ';
				}	
				$condition .= $fieldName . ' ' . $clause . $separator;
			}
		}
		return $condition;
	}
	
	/**
	 * Sets search conditions for finding resultsets
	 * @method search
	 * @param  string $id
	 * @return string
	 */
	public function search ($id = NULL) {
		$condition = $condition2 = '';
		$relationalOperator = '';
		$searchId = '';
		
		if ($this->obj->searchFields['unparsed'] != NULL || $id != NULL) {
			$searchFields = $this->obj->searchFields['unparsed'];
			
			$last = getLastKeyValue($this->obj->searchFields['unparsed']);
			$lastKey = $last['key'];
			$lastValue = $last['value'];
			
			foreach ($searchFields as $queries => $query){
				$operator = $queries;
				foreach ($query as $keys => $key) {
					foreach ($key as $field => $value) {
						$relationalOperator = '';
						if (count($searchFields) > 1 && ($lastKey != $field || $lastValue != $value)) {
							$relationalOperator = ' ' . strtoupper($this->obj->searchFields['operator']);
						}
						
						if ('in' != $operator && 'nin' != $operator &&
							'empty' != $value && 'false' != $value &&
							'true' != $value){
								$value = ' "' . $value . '" ';
						}
						
						if ("empty" == $value) {
							$value = '""';
						}else if ("false" == $value) {
							$value = 0;
						}else if ("true" == $value) {
							$value = 1;
						}else if ("null" == $value) {
							$value = NULL;
						}
						
						$condition .= $field . ' ' .  $this->operators[$operator] . $value . $relationalOperator . ' ' ;
					}
				}
			}
		}
		
		if (NULL != $id) {
			$searchId = 'id = ' . $id;
			$condition2 = $searchId;
		}
		
		$condition2 = ($this->obj->searchFields['unparsed'] != NULL) ? $relationalOperator : '' . $searchId;
		$params = $condition2;
		if (!empty($condition)){
			$params = $condition . $condition2;
		}
		return $params;
	}
	
	/**
	 * Get resultsets with the given query parameters
	 * @method respond
	 * @param  object
	 * @param  integer
	 * @return array
	 */
	public function response($model, $id = 0) {
		$results = $params = array();
		
		if ($this->obj->isPartial){
			$params['columns'] = $this->partial();
		}
		
		if ($this->obj->limit || $this->obj->limit != 0){
			$params['limit'] = $this->limit();
		}
		
		if ($this->obj->isSort){
			$params['sort'] = $this->sort();
		}
		
		if ($this->obj->isSearch || $this->obj->language || $id != 0){
			$condition = $this->search($id);
			$language = $operator = '';
			
			if (get_class($model) == 'App\Modules\Frontend\Models\Products' ||
				get_class($model) == 'App\Modules\Frontend\Models\Companies' ||
				get_class($model) == 'App\Modules\Frontend\Models\Areas' ||
				get_class($model) == 'App\Modules\Frontend\Models\Brands'
				) {
				if (!empty($condition)){
					$operator = 'AND';
				}
				$language = 'language = "' .  $this->obj->language . '"';
			}
			
			$conditions =  $condition . $language;
			$params['conditions'] = $conditions;
		}
		
		$newObjs = $model::find($params);
		if (!empty($newObjs)) {
			foreach ($newObjs as $newObj) {
				$newObj = objectToArray($newObj);
				$newObj['links']['rel'] = "self";				
				$newObj['links']['href'] = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REDIRECT_URL'] . $newObj['id'];
				$results[] = $newObj;
			}	
		}
		
		return $results;
	}
}