<?php
namespace App\Modules\Frontend\Controllers;

use App\Modules\Backend\Models\Verticals as Verticals,
	App\Modules\Frontend\Models\Verticals as VerticalsCollection,
    App\Common\Lib\Application\Controllers\RESTController;

class VerticalsController extends RESTController{
	
	/**
	 * Responds with information about newly inserted vertical
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function post($id){
		$results = array();
		$vertical = Verticals::findFirstById($id);
		if ($vertical != false){
			$verticalsCollection = new VerticalsCollection();
			$verticalsCollection->id = $vertical->id;
			$verticalsCollection->name = $vertical->name;
			$verticalsCollection->description = $vertical->description;
			$verticalsCollection->status = $vertical->status;
			$verticalsCollection->active = $vertical->active;
			$verticalsCollection->created = $vertical->created;
			$verticalsCollection->modified = $vertical->modified;
			$verticalsCollection->createdBy = $vertical->createdBy;
			$verticalsCollection->modifiedBy = $vertical->modifiedBy;
			$verticalsCollection->save();
			$results['id'] = $vertical->id;
		}
		return $results;
	}
	
	/**
	 * Responds with information about deleted vertical
	 *
	 * @method delete
	 * @return json/xml data
	 */
	public function delete($id){
		$results = array();
		$vertical = Verticals::findFirstById($id);
		if ($vertical != false){
			$verticalsCollection = VerticalsCollection::findFirst(array(array('id' => $id)));
			if ($verticalsCollection != false){
				$verticalsCollection->status = $vertical->status;
				$verticalsCollection->active = $vertical->active;
				$verticalsCollection->modified = $vertical->modified;
				$verticalsCollection->modifiedBy = $vertical->modifiedBy;
				$verticalsCollection->save();
				$results['id'] = $vertical->id;
			}
		}
		return $results;
	}
 	
	/**
	 * Responds with information about updated vertical
	 *
	 * @method put
	 * @return json/xml data
	 */
	public function put($id){
		$results = array();
		$vertical = Verticals::findFirstById($id);
		if ($vertical != false){
			$verticalsCollection = VerticalsCollection::findFirst(array(array('id' => $id)));
			if ($verticalsCollection != false){
				$verticalsCollection->id = $vertical->id;
				$verticalsCollection->name = $vertical->name;
				$verticalsCollection->description = $vertical->description;
				$verticalsCollection->status = $vertical->status;
				$verticalsCollection->active = $vertical->active;
				$verticalsCollection->created = $vertical->created;
				$verticalsCollection->modified = $vertical->modified;
				$verticalsCollection->createdBy = $vertical->createdBy;
				$verticalsCollection->modifiedBy = $vertical->modifiedBy;
				$verticalsCollection->save();
				$results['id'] = $vertical->id;
			}
		}
		return $results;
	}
}