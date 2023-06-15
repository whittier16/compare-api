<?php
namespace App\Modules\Frontend\Controllers;

use App\Modules\Backend\Models\Country as Country,
	App\Modules\Frontend\Models\Country as CountryCollection,
    App\Common\Lib\Application\Controllers\RESTController;


class CountryController extends RESTController{
	
	/**
	 * Responds with information about newly inserted country
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function post($id){
		$results = array();
		$country = Country::findFirstById($id);
		if ($country){
			$countryCollection = new CountryCollection();
			$countryCollection->id = $country->id;
			$countryCollection->name = $country->name;
			$countryCollection->description = $country->description;
			$countryCollection->status = $country->status;
			$countryCollection->active = $country->active;
			$countryCollection->created = $country->created;
			$countryCollection->modified = $country->modified;
			$countryCollection->createdBy = $country->createdBy;
			$countryCollection->modifiedBy = $country->modifiedBy;
			$countryCollection->save();
			$results['id'] = $country->id;
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
		$country = Country::findFirstById($id);
		if ($country){
			$countryCollection = CountryCollection::findFirst(array(array('id' => $id)));
			if ($countryCollection != false){
				$countryCollection->status = $country->status;
				$countryCollection->active = $country->active;
				$countryCollection->modified = $country->modified;
				$countryCollection->modifiedBy = $country->modifiedBy;
				$countryCollection->save();
				$results['id'] = $country->id;
			}
		}
		return $results;
	}
 	
	/**
	 * Responds with information about updated inserted country
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function put($id){
		$results = array();
		$country = Country::findFirstById($id);
		if ($country){
			$countryCollection = CountryCollection::findFirst(array(array('id' => $id)));
			if ($countryCollection != false){
				$countryCollection->id = $country->id;
				$countryCollection->name = $country->name;
				$countryCollection->description = $country->description;
				$countryCollection->status = $country->status;
				$countryCollection->active = $country->active;
				$countryCollection->created = $country->created;
				$countryCollection->modified = $country->modified;
				$countryCollection->createdBy = $country->createdBy;
				$countryCollection->modifiedBy = $country->modifiedBy;
				$countryCollection->save();
				$results['id'] = $country->id;
			}
		}
		return $results;
	}
}