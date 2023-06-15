<?php
namespace App\Modules\Frontend\Controllers;

use App\Modules\Backend\Models\CompaniesOptions as CompaniesOptions,
	App\Modules\Frontend\Models\CompaniesOptions as CompaniesOptionsCollection,
	App\Modules\Frontend\Models\Companies as CompaniesCollection,
	App\Modules\Frontend\Models\Brands as BrandsCollection,
    App\Common\Lib\Application\Controllers\RESTController;


class CompaniesOptionsController extends RESTController{
	
	/**
	 * Responds with information about newly inserted company option
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function post($id){
		$results = array();
		$companiesOption = CompaniesOptions::findFirstById($id);
		if ($companiesOption){
			$companiesOptionCollection = new CompaniesOptionsCollection();
			$companiesOptionCollection->id = $companiesOption->id;
			$companiesOptionCollection->modelId = $companiesOption->modelId;
			$companiesOptionCollection->category = $companiesOption->category;
			$companiesOptionCollection->name = $companiesOption->name;
			$companiesOptionCollection->value = $companiesOption->value;
			$companiesOptionCollection->label = $companiesOption->label;
			$companiesOptionCollection->status = $companiesOption->status;
			$companiesOptionCollection->active = $companiesOption->active;
			$companiesOptionCollection->editable = $companiesOption->editable;
			$companiesOptionCollection->visibility = $companiesOption->visibility;
			$companiesOptionCollection->created = $companiesOption->created;
			$companiesOptionCollection->modified = $companiesOption->modified;
			$companiesOptionCollection->createdBy = $companiesOption->createdBy;
			$companiesOptionCollection->modifiedBy = $companiesOption->modifiedBy;
			$success = $companiesOptionCollection->save();
			if ($success){
				if ('company' == $companiesOption->category && 1 == $companiesOption->status) {
					$collection = CompaniesCollection::findFirst(array(array('id' => $companiesOption->modelId)));
				}else if ('brand' == $companiesOption->category && 1 == $companiesOption->status) {
					$collection = BrandsCollection::findFirst(array(array('id' => $companiesOption->modelId)));
				}
				if ($collection){
					$name = $companiesOption->name;
					$collection->$name = $companiesOption->value;
					$collection->save();
					$results['id'] = $companiesOption->id;
				}
			}
		}
		return $results;
	}
	
	/**
	 * Responds with information about deleted record
	 *
	 * @method delete
	 * @return json/xml data
	 */
	public function delete($id){
		$results = array();
		$companiesOption = CompaniesOptions::findFirstById($id);
		if ($companiesOption != false){
			$companiesOptionCollection = CompaniesOptionsCollection::findFirst(array(array('id' => $id)));
			if ($companiesOptionCollection != false){
				$companiesOptionCollection->status = $companiesOption->status;
				$companiesOptionCollection->active = $companiesOption->active;
				$companiesOptionCollection->editable = $companiesOption->editable;
				$companiesOptionCollection->visibility = $companiesOption->visibility;
				$companiesOptionCollection->modified = $companiesOption->modified;
				$companiesOptionCollection->modifiedBy = $companiesOption->modifiedBy;
				$success = $companiesOptionCollection->save();
				if ($success){
					if ('company' == $companiesOption->category && 0 == $companiesOption->status) {
						$collection = CompaniesCollection::findFirst(array(array('id' => $companiesOption->modelId)));
					}else if ('brand' == $companiesOption->category && 0 == $companiesOption->status) {
						$collection = BrandsCollection::findFirst(array(array('id' => $companiesOption->modelId)));
					}
					if ($collection){
						$name = $companiesOption->name;
						unset($collection->$name);
						$collection->save();
						$results['id'] = $companiesOption->id;
					}
				}
			}
		}
		return $results;
	}
 	
	/**
	 * Responds with information about updated inserted company option
	 *
	 * @method put
	 * @return json/xml data
	 */
	public function put($id){
		$results = array();
		$companiesOption = CompaniesOptions::findFirstById($id);
		if ($companiesOption){
			$companiesOptionCollection = CompaniesOptionsCollection::findFirst(array(array('id' => $id)));
			if ($companiesOptionCollection != false){
				$companiesOptionCollection->id = $companiesOption->id;
				$companiesOptionCollection->modelId = $companiesOption->modelId;
				$companiesOptionCollection->category = $companiesOption->category;	
				$companiesOptionCollection->name = $companiesOption->name;
				$companiesOptionCollection->value = $companiesOption->value;
				$companiesOptionCollection->label = $companiesOption->label;
				$companiesOptionCollection->status = $companiesOption->status;
				$companiesOptionCollection->active = $companiesOption->active;
				$companiesOptionCollection->editable = $companiesOption->editable;
				$companiesOptionCollection->visibility = $companiesOption->visibility;
				$companiesOptionCollection->created = $companiesOption->created;
				$companiesOptionCollection->modified = $companiesOption->modified;
				$companiesOptionCollection->createdBy = $companiesOption->createdBy;
				$companiesOptionCollection->modifiedBy = $companiesOption->modifiedBy;
				$companiesOptionCollection->save();
				$success = $companiesOptionCollection->save();
				if ($success){
					if ('company' == $companiesOption->category &&  1 == $companiesOption->status) {
						$collection = CompaniesCollection::findFirst(array(array('id' => $companiesOption->modelId)));
					}else if ('brand' == $companiesOption->category && 1 == $companiesOption->status) {
						$collection = BrandsCollection::findFirst(array(array('id' => $companiesOption->modelId)));
					}
					if ($collection){
						$name = $companiesOption->name;
						$collection->$name = $companiesOption->value;
						$collection->save();
						$results['id'] = $companiesOption->id;
					}
				}
			}
		}
		return $results;
	}
}