<?php
namespace App\Modules\Frontend\Controllers;

use App\Modules\Backend\Models\Brands as Brands,
	App\Modules\Frontend\Models\Brands as BrandsCollection,
    App\Common\Lib\Application\Controllers\RESTController;

class BrandsController extends RESTController{	
	
	/**
	 * Responds with information about newly inserted brand
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function post($id){
		$results = array();
		$brand = Brands::findFirstById($id);
		if ($brand){
			$brandCollection = new BrandsCollection();
			$brandCollection->id = $brand->id;
			$brandCollection->companyId = $brand->companyId;
			$brandCollection->name = $brand->name;
			$brandCollection->alias = $brand->alias;
			$brandCollection->logo = $brand->logo;
			$brandCollection->link = $brand->link;
			$brandCollection->description = $brand->description;
			$brandCollection->language = $brand->language;
			$brandCollection->revenueValue = $brand->revenueValue;
			$brandCollection->status = $brand->status;
			$brandCollection->active = $brand->active;
			$brandCollection->created = $brand->created;
			$brandCollection->modified = $brand->modified;
			$brandCollection->createdBy = $brand->createdBy;
			$brandCollection->modifiedBy = $brand->modifiedBy;
			$brandCollection->save();
			$results['id'] = $brand->id;
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
		$brand = Brands::findFirstById($id);
		if ($brand != false){
			$brandCollection = BrandsCollection::findFirst(array(array('id' => $id)));
			if ($brandCollection != false){
				$brandCollection->status = $brand->status;
				$brandCollection->active = $brand->active;
				$brandCollection->modified = $brand->modified;
				$brandCollection->modifiedBy = $brand->modifiedBy;
				$brandCollection->save();
				$results['id'] = $brand->id;
			}
		}
		return $results;
	}
 	
	/**
	 * Responds with information about updated inserted brand
	 *
	 * @method put
	 * @return json/xml data
	 */
	public function put($id){
		$results = array();
		$brand = Brands::findFirstById($id);
		if ($brand){
			$brandCollection = BrandsCollection::findFirst(array(array('id' => $id)));
			if ($brandCollection != false){
				$brandCollection->id = $brand->id;
				$brandCollection->companyId = $brand->companyId;
				$brandCollection->name = $brand->name;
				$brandCollection->alias = $brand->alias;
				$brandCollection->logo = $brand->logo;
				$brandCollection->link = $brand->link;
				$brandCollection->description = $brand->description;
				$brandCollection->language = $brand->language;
				$brandCollection->revenueValue = $brand->revenueValue;
				$brandCollection->active = $brand->active;
				$brandCollection->created = $brand->created;
				$brandCollection->modified = $brand->modified;
				$brandCollection->createdBy = $brand->createdBy;
				$brandCollection->modifiedBy = $brand->modifiedBy;
				$brandCollection->save();
				$results['id'] = $brand->id;
			}
		}
		return $results;
	}
}