<?php
namespace App\Modules\Frontend\Controllers;

use \App\Modules\Frontend\Models\Products as ProductsCollection,
	\App\Modules\Backend\Models\Products,
	\App\Common\Lib\Application\Controllers\RESTController;
	
class ProductsController extends RESTController {
	
	/**
	 * Responds with information about newly inserted product
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function post($id){
		$results = array();
		$product = Products::findFirstById($id);
		if ($product){
			$productsCollection = new ProductsCollection();
			$productsCollection->id = $id;
			$productsCollection->channelId = $product->channelId;
			$productsCollection->brandId = $product->brandId;
			$productsCollection->name = $product->name;
			$productsCollection->alias = $product->alias;
			$productsCollection->description = $product->description;
			$productsCollection->featured = $product->featured;
			$productsCollection->icon = $product->icon;
			$productsCollection->language = $product->language;
			$productsCollection->status = $product->status;
			$productsCollection->active = $product->active;
			$productsCollection->created = $product->created;
			$productsCollection->modified = $product->modified;
			$productsCollection->createdBy = $product->createdBy;
			$productsCollection->modifiedBy = $product->modifiedBy;
			$productsCollection->save();
		}
		return $results;
	}
	
	/**
	 * Responds with information about updated inserted product
	 *
	 * @method put
	 * @return json/xml data
	 */
	public function put($id){
		$results = array();
		$product = Products::findFirstById($id);
		if ($product){
			$productsCollection = ProductsCollection::findFirst(array(array('id' => $id)));
			if ($productsCollection != false){
				$productsCollection->id = $id;
				$productsCollection->channelId = $product->channelId;
				$productsCollection->brandId = $product->brandId;
				$productsCollection->name = $product->name;
				$productsCollection->alias = $product->alias;
				$productsCollection->description = $product->description;
				$productsCollection->featured = $product->featured;
				$productsCollection->icon = $product->icon;
				$productsCollection->language = $product->language;
				$productsCollection->status = $product->status;
				$productsCollection->active = $product->active;
				$productsCollection->created = $product->created;
				$productsCollection->modified = $product->modified;
				$productsCollection->createdBy = $product->createdBy;
				$productsCollection->modifiedBy = $product->modifiedBy;
				$productsCollection->save();
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
		$product = Products::findFirstById($id);
		if ($product != false){
			$productsCollection = ProductsCollection::findFirst(array(array('id' => $id)));
			if ($productsCollection != false){
				$productsCollection->status = $product->status;
				$productsCollection->active = $product->active;
				$productsCollection->modified = $product->modified;
				$productsCollection->modifiedBy = $product->modifiedBy;
				$productsCollection->save();
				$results['id'] = $product->id;
			}
		}
		return $results;
	}
}