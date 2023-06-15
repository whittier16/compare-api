<?php
namespace App\Modules\Frontend\Controllers;

use App\Modules\Backend\Models\ProductsOptions as ProductsOptions,
	App\Modules\Frontend\Models\ProductsOptions as ProductsOptionsCollection,
	App\Modules\Frontend\Models\Products as Products,
    App\Common\Lib\Application\Controllers\RESTController;


class ProductsOptionsController extends RESTController{
	
	/**
	 * Responds with information about newly inserted products option
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function post($id){
		$results = array();
		$productsOption = ProductsOptions::findFirstById($id);
		if ($productsOption){
			$productsOptionCollection = new ProductsOptionsCollection();
			$productsOptionCollection->id = $productsOption->id;
			$productsOptionCollection->productId = $productsOption->productId;
			$productsOptionCollection->areaId = $productsOption->areaId;
			$productsOptionCollection->name = $productsOption->name;
			$productsOptionCollection->value = $productsOption->value;
			$productsOptionCollection->label = $productsOption->label;
			$productsOptionCollection->status = $productsOption->status;
			$productsOptionCollection->active = $productsOption->active;
			$productsOptionCollection->editable = $productsOption->editable;
			$productsOptionCollection->visibility = $productsOption->visibility;
			$productsOptionCollection->created = $productsOption->created;
			$productsOptionCollection->modified = $productsOption->modified;
			$productsOptionCollection->createdBy = $productsOption->createdBy;
			$productsOptionCollection->modifiedBy = $productsOption->modifiedBy;
			$success = $productsOptionCollection->save();
			if ($success){
				if (1 == $productsOption->status){
					$products = Products::findFirst(array(array('id' => $productsOption->productId)));
					if ($products){
						$name = $productsOption->name;
						$products->$name = $productsOption->value;
						$products->save();
						$results['id'] = $productsOption->id;
					}
				}
			}
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
		$productsOption = ProductsOptions::findFirstById($id);
		if ($productsOption){
			$productsOptionCollection = ProductsOptionsCollection::findFirst(array(array('id' => $id)));
			if ($productsOptionCollection != false){
				$productsOptionCollection->status = $productsOption->status;
				$productsOptionCollection->active = $productsOption->active;
				$productsOptionCollection->modified = $productsOption->modified;
				$productsOptionCollection->modifiedBy = $productsOption->modifiedBy;
				$success = $productsOptionCollection->save();
				if ($success){
					if (0 == $productsOption->status){
						$products = Products::findFirst(array(array('id' => $productsOption->productId)));
						if ($products){
							$name = $productsOption->name;
							unset($products->$name);
							$products->save();
							$results['id'] = $productsOption->id;
						}
					}
				}
			}
		}	
	}
 	
	/**
	 * Responds with information about updated inserted products option
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function put($id){
		$results = array();
		$productsOption = ProductsOptions::findFirstById($id);
		if ($productsOption){
			$productsOptionCollection = ProductsOptionsCollection::findFirst(array(array('id' => $id)));
			if ($productsOptionCollection != false){
				$productsOptionCollection->id = $productsOption->id;
				$productsOptionCollection->productId = $productsOption->productId;
				$productsOptionCollection->areaId = $productsOption->areaId;
				$productsOptionCollection->name = $productsOption->name;
				$productsOptionCollection->value = $productsOption->value;
				$productsOptionCollection->label = $productsOption->label;
				$productsOptionCollection->status = $productsOption->status;
				$productsOptionCollection->active = $productsOption->active;
				$productsOptionCollection->editable = $productsOption->editable;
				$productsOptionCollection->visibility = $productsOption->visibility;
				$productsOptionCollection->created = $productsOption->created;
				$productsOptionCollection->modified = $productsOption->modified;
				$productsOptionCollection->createdBy = $productsOption->createdBy;
				$productsOptionCollection->modifiedBy = $productsOption->modifiedBy;
				$success = $productsOptionCollection->save();
				if ($success){
					if (1 == $productsOption->status){
						$products = Products::findFirst(array(array('id' => $productsOption->productId)));
						if ($products){
							$name = $productsOption->name;
							$products->$name = $productsOption->value;
							$products->save();
							$results['id'] = $productsOption->id;
						}
					}
				}
			}
		}
		return $results;
	}
}