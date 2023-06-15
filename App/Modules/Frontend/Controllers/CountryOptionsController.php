<?php
namespace App\Modules\Frontend\Controllers;

use App\Modules\Backend\Models\CountryOptions as CountryOptions,
	App\Modules\Frontend\Models\CountryOptions as CountryOptionsCollection,
	App\Modules\Frontend\Models\Country as Country,
    App\Common\Lib\Application\Controllers\RESTController;


class CountryOptionsController extends RESTController{
	
	/**
	 * Responds with information about newly inserted companies option
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function post($id){
		$results = array();
		$countryOption = CountryOptions::findFirstById($id);
		if ($countryOption){
			$countryOptionCollection = new CountryOptionsCollection();
			$countryOptionCollection->id = $countryOption->id;
			$countryOptionCollection->countryId = $countryOption->countryId;
			$countryOptionCollection->name = $countryOption->name;
			$countryOptionCollection->value = $countryOption->value;
			$countryOptionCollection->label = $countryOption->label;
			$countryOptionCollection->status = $countryOption->status;
			$countryOptionCollection->active = $countryOption->active;
			$countryOptionCollection->editable = $countryOption->editable;
			$countryOptionCollection->visibility = $countryOption->active;
			$countryOptionCollection->created = $countryOption->created;
			$countryOptionCollection->modified = $countryOption->modified;
			$countryOptionCollection->createdBy = $countryOption->createdBy;
			$countryOptionCollection->modifiedBy = $countryOption->modifiedBy;
			$success = $countryOptionCollection->save();
			if ($success){
				if (1 == $countryOption->status){
					$country = Country::findFirst(array(array('id' => $countryOption->countryId)));
					if ($country){
						$name = $countryOption->name;
						$country->$name = $countryOption->value;
						$country->save();
						$results['id'] = $countryOption->id;
					}
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
		$countryOption = CountryOptions::findFirstById($id);
		if ($countryOption){
			$countryOptionsCollection = CountryOptionsCollection::findFirst(array(array('id' => $id)));
			if ($countryOptionsCollection != false){
				$countryOptionsCollection->status = $countryOption->status;
				$countryOptionsCollection->active = $countryOption->active;
				$countryOptionsCollection->modified = $countryOption->modified;
				$countryOptionsCollection->modifiedBy = $countryOption->modifiedBy;
				$success = $countryOptionsCollection->save();
				if ($success){
					if (0 == $countryOption->status){
						$country = Country::findFirst(array(array('id' => $countryOption->countryId)));
						if ($country){
							$name = $countryOption->name;
							unset($country->$name);
							$country->save();
							$results['id'] = $countryOption->id;
						}
					}
				}
			}
		}
		return $results;
	}
 	
	/**
	 * Responds with information about updated inserted company
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function put($id){
		$results = array();
		$countryOption = CountryOptions::findFirstById($id);
		if ($countryOption){
			$countryOptionsCollection = CountryOptionsCollection::findFirst(array(array('id' => $id)));
			if ($countryOptionsCollection != false){
				$countryOptionCollection->id = $countryOption->id;
				$countryOptionCollection->countryId = $countryOption->countryId;
				$countryOptionCollection->name = $countryOption->name;
				$countryOptionCollection->value = $countryOption->value;
				$countryOptionCollection->label = $countryOption->label;
				$countryOptionCollection->status = $countryOption->status;
				$countryOptionCollection->active = $countryOption->active;
				$countryOptionCollection->editable = $countryOption->editable;
				$countryOptionCollection->visibility = $countryOption->active;
				$countryOptionCollection->created = $countryOption->created;
				$countryOptionCollection->modified = $countryOption->modified;
				$countryOptionCollection->createdBy = $countryOption->createdBy;
				$countryOptionCollection->modifiedBy = $countryOption->modifiedBy;
				$success = $countryOptionsCollection->save();
				if ($success){
					if (1 == $countryOption->status){
						$country = Country::findFirst(array(array('id' => $countryOption->countryId)));
						if ($country){
							$name = $countryOption->name;
							$country->$name = $countryOption->value;
							$country->save();
							$results['id'] = $countryOption->id;
						}
					}
				}
			}
		}
		return $results;
	}
}