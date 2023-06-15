<?php
namespace App\Modules\Frontend\Controllers;

use App\Modules\Frontend\Models\Options as OptionsCollection,
	App\Modules\Backend\Models\Options as Options,
	App\Common\Lib\Application\Controllers\RESTController;

class OptionsController extends RESTController{
	
	/**
	 * Responds with information about newly inserted option
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function post($id){
		$results = array();
		$option = Options::findFirst($id);
		if ($option){
			$optionCollection = new OptionsCollection();
			$optionCollection->id = $option->id;
			$optionCollection->type = $option->type;
			$optionCollection->name = $option->name;
			$optionCollection->value = $option->value;
			$optionCollection->label = $option->label;
			$optionCollection->status = $option->status;
			$optionCollection->created = $option->created;
			$optionCollection->modified = $option->modified;
			$optionCollection->save();
			$results['id'] = $option->id;
		}
		return $results;
	}
	
	/**
	 * Responds with information about deleted record
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function delete($id){
		$option = OptionsCollection::findFirst(array(array('id' => $id)));
		return $option->delete();
	}
 	
	/**
	 * Responds with information about updated inserted option
	 *
	 * @method put
	 * @return json/xml data
	 */
	public function put($id){
		$results = array();
		$option = Options::findFirst($id);
		if ($option){
			$optionCollection = OptionsCollection::findFirst(array(array('id' => $id)));
			$optionCollection->id = $option->id;
			$optionCollection->type = $option->type;
			$optionCollection->name = $option->name;
			$optionCollection->value = $option->value;
			$optionCollection->label = $option->label;
			$optionCollection->status = $option->status;
			$optionCollection->created = $option->created;
			$optionCollection->modified = $option->modified;
			$results['id'] = $option->id;
		}
		return $results;
	}
}