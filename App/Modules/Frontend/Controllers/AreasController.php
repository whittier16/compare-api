<?php
namespace App\Modules\Frontend\Controllers;

use App\Modules\Backend\Models\Areas,
	App\Modules\Frontend\Models\Areas as AreasCollection,
	App\Common\Lib\Application\Controllers\RESTController;

class AreasController extends RESTController{

	/**
	 * Responds with information about newly inserted area
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function post($id){
		$results = array();
		$area = Areas::findFirstById($id);
		if ($area){
			$areaCollection = new AreasCollection();
			$areaCollection->id = $area->id;
			$areaCollection->name = $area->name;
			$areaCollection->category = $area->category;
			$areaCollection->description = $area->description;
			$areaCollection->language = $area->language;
			$areaCollection->bounds = $area->bounds;
			$areaCollection->parentId = $area->parentId;
			$areaCollection->lft = $area->lft;
			$areaCollection->rght = $area->rght;
			$areaCollection->scope = $area->scope;
			$areaCollection->status = $area->status;
			$areaCollection->active = $area->active;
			$areaCollection->created = $area->created;
			$areaCollection->modified = $area->modified;
			$areaCollection->createdBy = $area->createdBy;
			$areaCollection->modifiedBy = $area->modifiedBy;
			$areaCollection->save();
			$results['id'] = $area->id;
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
		$results = array();
		$area = Areas::findFirstById($id);
		if ($area){
			$areasCollection = AreasCollection::findFirst(array(array('id' => $id)));
			if ($areasCollection != false){
				$areasCollection->status = $area->status;
				$areasCollection->active = $area->active;
				$areasCollection->modified = $area->modified;
				$areasCollection->modifiedBy = $area->modifiedBy;
				$areasCollection->save();
				$results['id'] = $area->id;
			}
		}
		return $results;
	}
 	
	/**
	 * Responds with information about updated inserted area
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function put($id){
		$results = array();
		$area = Areas::findFirstById($id);
		if ($area){
			$areasCollection = AreasCollection::findFirst(array(array('id' => $id)));
			if ($areasCollection != false){
				$areasCollection->id = $area->id;
				$areasCollection->name = $area->name;
				$areasCollection->category = $area->category;
				$areasCollection->description = $area->description;
				$areasCollection->language = $area->language;
				$areasCollection->bounds = $area->bounds;
				$areasCollection->parentId = $area->parentId;
				$areasCollection->lft = $area->lft;
				$areasCollection->rght = $area->rght;
				$areasCollection->scope = $area->scope;
				$areasCollection->status = $area->status;
				$areasCollection->active = $area->active;
				$areasCollection->created = $area->created;
				$areasCollection->modified = $area->modified;
				$areasCollection->createdBy = $area->createdBy;
				$areasCollection->modifiedBy = $area->modifiedBy;
				$areasCollection->save();
				$results['id'] = $area->id;
			}
		}
		return $results;
	}
}