<?php
namespace App\Common\Lib\Application\Models;

use App\Common\Lib\Application\Libraries\Filterus\Filter;

class ModelBase extends \Phalcon\Mvc\Model
{	
	/**
	 * Responds with columns about models
	 *
	 * @method mapColumn
	 * @param  object $model
	 * @param  integer $id
	 * @return array
	 */
	public function mapColumn($model, $id){
		$results = array();
		$metaData = new \Phalcon\Mvc\Model\MetaData\Memory();
		$columnMap = $metaData->getColumnMap($model);
		$result = $model::findFirst($id);
		foreach ($columnMap as $column) {
			$results[$column] = $result->$column;
		}
		return $results;
	}
	
	/**
	 * Responds with messages about models
	 *
	 * @method getMessages
	 * @param  string $filter
	 * @return array
	 */
	public function getMessages($filter = NULL)
	{
		$messages = array();
		foreach (parent::getMessages() as $message) {
			switch ($message->getType()) {
				case 'InvalidCreateAttempt':
					$messages[] = 'The record cannot be created because it already exists.';
					break;
				case 'InvalidUpdateAttempt':
					$messages[] = 'The record cannot be updated because it already exists.';
					break;
				case 'PresenceOf':
					$messages[] = 'The field ' . $message->getField() . ' is mandatory.';
					break;
				default:
					$messages[] = $message->getMessage();
					break;
			}
		}
		return $messages;
	}
	
	/**
	 * Responds with messages about models
	 *
	 * @method validation
	 * @param  array $parameters
	 * @param  array $jsonSchema
	 * @return boolean
	 */
	public function validateProperty($fields = NULL, $jsonSchema = NULL){
		$valid = array();
		$retVal = "";
		$output = readJsonFromFile($jsonSchema, $this);
		if (!empty($output)) { 
			if ( substr( get_class( $this ), -7) == 'Options') {
				$properties = $output['properties']['options'];
			} else {
				$properties = $output['properties'];
			}
			foreach ($fields as $fieldKey => $fieldValue){
				if (array_key_exists($fieldKey, $properties)){
					$retVal = $this->getValidators($fieldValue, $properties[$fieldKey]);
					if ($retVal!== '') { 
						$valid[] = $this->getValidators($fieldValue, $properties[$fieldKey]);
					}
				}
			}
		}
		return $valid;
	}

	public function processString($rule, $options) {
		$filter = '';
		switch ( $rule ) {
			case 'minLength' :
				$filter = "min:" . $options['min'];
				break;
			case 'maxLength' :
				$filter = "max:" . $options['max'];
				break;
			case 'slug' :
				$filter = "regex:" . '[a-zA-Z0-9' . $options['separator'] . ']/';
				break;
		}
		return $filter;
	}

	public function processInt($rule,$options) {
		$filter = '';
		switch ( $rule ) {
			case 'min' :
				$filter = null != isset($options['min']) ? "min:" . $options['min'] : "";
				break;
			case 'max' :
				$filter = null != isset($options['max']) ? "max:" . $options['max'] : "";
				break;
		}
		return $filter;
	}
	
	public function getValidators($field, $properties){
		$type = $properties['type'];
		$label = $properties['label'];
		$validators = $properties['validators'];
		$required = $properties['required'];
		$min = $max = '';
		$filter = array();
		if (!empty($validators)) {
			$filter[] = $type;
			foreach ($validators as $key => $value) {
				if (array_key_exists('rule', $value)) {
					$rule = $value['rule'];
					$options = !(empty($value['options']))? $value['options'] : '';
					switch ( $type ) {
						case 'string' :
							$filter[] = $this->processString($rule, $options);
							break;
						case 'int' :
							$filter[] = $this->processInt($rule, $options);
							break;
						case 'regex' :
							$filter[] = $this->processRegex($rule, $options);
							break;
						case 'email' :
							$filter[] = 'email';
							break;
						case 'url' :
							$filter[] = 'url';
							break;
					}
				}		
			}
		}
		
		// blank and non-mandatory field will be skipped
		if (!$required && trim($field) === '' && is_null($field)) {
			return "";
		}
		
		var_dump($required);
		
		if ($filter != '') {
			$filter = implode(",", $filter);
		}
		
		$array = array(
			$label => $field,
		);
		
		
		$filterus = Filter::map(array(
			$label => $filter,
		));
		
		if ($filterus->validate($array)) {
			return "";
		} else {
			if (count($validators) > 1){
				foreach ($validators as $validator){
					$messages[] = $validator['message'];
				}
				$messages = implode(", " , $messages);
			} else { 
				$messages = $validators[0]['message'];
			}
			return $messages;
		}
	}

	public function processRequired(){
		
	} 
	
	public function uuid()
	{
		$result = $this->getDI()->getDb()->query("SELECT UUID()");
		$arr = $result->fetch();
		return $arr[0];
	}
}