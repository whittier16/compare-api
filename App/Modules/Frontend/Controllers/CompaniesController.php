<?php
namespace App\Modules\Frontend\Controllers;

use App\Modules\Backend\Models\Companies as Companies,
	App\Modules\Frontend\Models\Companies as CompaniesCollection,
    App\Common\Lib\Application\Controllers\RESTController;


class CompaniesController extends RESTController{
	
	/**
	 * Responds with information about newly inserted company
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function post($id){
		$company = Companies::findFirstById($id);
		if ($company){
			// $companiesOtions = $company->getCompaniesOptions();
			$companyCollection = new CompaniesCollection();
			$companyCollection->id = $company->id;
			$companyCollection->name = $company->name;
			$companyCollection->alias = $company->alias;
			$companyCollection->logo = $company->logo;
			$companyCollection->link = $company->link;
			$companyCollection->description = $company->description;
			$companyCollection->language = $company->language;
			$companyCollection->revenueValue = $company->revenueValue;
			$companyCollection->status = $company->status;
			$companyCollection->active = $company->active;
			$companyCollection->created = $company->created;
			$companyCollection->modified = $company->modified;
			$companyCollection->save();
			$results['id'] = $company->id;
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
		$company = Companies::findFirstById($id);
		if ($company != false){
			$companyCollection = CompaniesCollection::findFirst(array(array('id' => $id)));
			if ($companyCollection != false){
				$companyCollection->status = $company->status;
				$companyCollection->active = $company->active;
				$companyCollection->modified = $company->modified;
				$companyCollection->modifiedBy = $company->modifiedBy;
				$companyCollection->save();
				$results['id'] = $company->id;
			}
		}
		return $results;
	}
 	
	/**
	 * Responds with information about updated inserted company
	 *
	 * @method put
	 * @return json/xml data
	 */
	public function put($id){
		$company = Companies::findFirstById($id);
		if ($company){
			$companyCollection = CompaniesCollection::findFirst(array(array('id' => $id)));
			if ($companyCollection != false){
				$companyCollection->id = $company->id;
				$companyCollection->name = $company->name;
				$companyCollection->alias = $company->alias;
				$companyCollection->logo = $company->logo;
				$companyCollection->link = $company->link;
				$companyCollection->description = $company->description;
				$companyCollection->language = $company->language;
				$companyCollection->revenueValue = $company->revenueValue;
				$companyCollection->status = $company->status;
				$companyCollection->active = $company->active;
				$companyCollection->created = $company->created;
				$companyCollection->modified = $company->modified;
				$companyCollection->save();
				$results['id'] = $company->id;
			}
		}
		return $results;
	}
}