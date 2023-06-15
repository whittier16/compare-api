<?php
namespace App\Modules\Backend\Controllers;

use App\Modules\Backend\Models\CountryOptions,
	App\Modules\Frontend\Models\CountryOptions as CountryOptionsCollection,
	App\Common\Lib\Application\Controllers\RESTController,
	App\Common\Lib\Application\Exceptions\HTTPException;
use App\Modules\Backend\Models\Country;


class CountryOptionsController extends RESTController{

	/**
	 * Sets which fields may be searched against, and which fields are allowed to be returned in
	 * partial responses. 
	 * @var array
	 */
	protected $allowedFields = array(
		'search' => array(
				'id',
				'countryId',
				'name', 
				'value', 
				'label',
				'editable',
				'visibility',
				'status',
				'active',
				'created',
				'modified',
				'createdBy',
				'modifiedBy'
		),
		'partials' => array(
				'id',
				'countryId',
				'name', 
				'value', 
				'label',
				'editable',
				'visibility',
				'status',
				'active',
				'created',
				'modified',
				'createdBy',
				'modifiedBy'
		),
		'sort' => array(
				'id',
				'countryId',
				'name', 
				'value', 
				'label',
				'editable',
				'visibility',
				'status',
				'active',
				'created',
				'modified',
				'createdBy',
				'modifiedBy'
		)	
	);
	
	/**
	 * Sets which objects may be searched against, and which objects are allowed to be returned in
	 * partial responses.
	 * @var array
	 */
	protected $allowedObjects = array(
	);
	
	/**
	 * Country Options constructor
	 */
	public function __construct(){
		parent::__construct(false, false);
		$this->parseRequest($this->allowedFields, $this->allowedObjects);
	}
	
	/**
	 * @api {get} /country_options GET /country_options
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/country_options/?countryCode=ph&language=en&
	 *          query={"status":"1"}&fields=id,countryId,name,value,label,editable,visibility,status&
	 *          sort=id,name&
	 *          limit=10"
	 *
	 * @apiDescription Read data of all Country Options
	 * @apiName        Get
	 * @apiGroup       Country Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Country Options unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} [query]                  Optional query conditions that rows must satisfy to be selected.
	 * @apiParam       {String} [fields]                 Optional field indicates a column that you want to retrieve.
	 * @apiParam       {String} [sort]                   Optional sort orders columns selected for output.
	 * @apiParam       {String} [limit=0]                Optional limit used to constrain the number of rows returned.
	 * 													 When offset parameter is present, the limit specifies the offset
	 *                                                   of the first row to return. When count parameter exists, the limit 
	 *                                                   identifies all the rows returned and with default 0.
	 * @apiParam       {String} [offset]                 Optional offset specifies the maximum number of rows to return.
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of country options.
	 * 
	 * @apiSuccess     {String} id                       ID of the Country Options. 
	 * @apiSuccess     {String} countryId                Country ID of the Country Options. 
	 * @apiSuccess     {String} name                     Name of the Channels Options. 
	 * @apiSuccess     {String} value                    Value of the Channels Options. 
	 * @apiSuccess     {String} label                    Label of the Channels Options.
	 * @apiSuccess     {String} editable                 Editable Flag of the Country Options. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Country Options.  
	 * @apiSuccess     {Number} status                   Status Flag of the Country Options. 
	 * @apiSuccess     {Number} active                   Active Flag of the Country Options. 
	 * @apiSuccess     {Date}   created                  Creation date of the Country Options. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Country Options. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Country Options. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Country Options. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "1535ebcc-22b8-11e4-bd33-17609cecca2f",
     *       "name": "iso2",
     *       "description": "",
     *       "editable": "1",
     *       "visibility": "1",
     *       "status": "1"
     *     },
	 *     {
     *       "id": "1535ebcc-22b8-11e4-bd33-17609cecca2f",
     *       "name": "shortname",
     *       "description": "",
     *       "editable": "1",
     *       "visibility": "1",
     *       "status": "1"	
     *     }
	 *
	 * @apiError InvalidAccessToken The access token is invalid.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "InvalidAccessToken"
	 *     }
	 *
	 * @apiError MissingAuthenticationCredentials The authentication credentials are missing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "MissingAuthenticationCredentials"
	 *     }
	 *     
	 * @apiError WrongFieldsReturned The requested fields are not available.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "WrongFieldsReturned"
	 *     }     
	 */
	public function get(){
		$countryOptions = new CountryOptionsCollection($this->di);
		return $this->respond($countryOptions);
	}
	
	/**
	 * @api {get} /country_options/:id GET /country_options/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -i "http://apibeta.compargo.com/v1/country_options/05a5ec26-372a-11e4-b18a-fe7344fb1ea4/?countryCode=ph&language=en"
	 *
	 * @apiDescription Read data of a Countries Options
	 * @apiName        GetOne
	 * @apiGroup       Country Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Country Options unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Countries Options unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Country Options. 
	 * @apiSuccess     {String} countryId                Country ID of the Country Options. 
	 * @apiSuccess     {String} name                     Name of the Channels Options. 
	 * @apiSuccess     {String} value                    Value of the Channels Options. 
	 * @apiSuccess     {String} label                    Label of the Channels Options.
	 * @apiSuccess     {String} editable                 Editable Flag of the Country Options. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Country Options.  
	 * @apiSuccess     {Number} status                   Status Flag of the Country Options. 
	 * @apiSuccess     {Number} active                   Active Flag of the Country Options. 
	 * @apiSuccess     {Date}   created                  Creation date of the Country Options. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Country Options. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Country Options. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Country Options. 
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "1535ebcc-22b8-11e4-bd33-17609cecca2f",
     *       "name": "iso2",
     *       "description": "",
     *       "editable": "1",
     *       "visibility": "1",
     *       "status": "1"
     *     }
	 *
	 * @apiError CountryOptionNotFound The id of the Country Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CountryOptionNotFound"
	 *     }
	 *
	 * @apiError InvalidAccessToken The access token is invalid.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "InvalidAccessToken"
	 *     }
	 *
	 * @apiError MissingAuthenticationCredentials The authentication credentials are missing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "MissingAuthenticationCredentials"
	 *     }
	 *
	 * @apiError RouteNotFound That route was not found on the server.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404
	 *     {
	 *       "error": "RouteNotFound"
	 *     }
	 */
	public function getOne($id){
		$request = $this->di->get('request');
		$parameters = $request->get();
		if (count($parameters) > 1) {
			$countryOptions = new CountryOptionsCollection($this->di);
			$results = $this->respond($countryOptions, $id);
		}else{
			$results = CountryOptionsCollection::find(array(
				array("id" => $id)
			));
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Country option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * @api {post} /country_options POST /country_options
     * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/country_options/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "countryId=4de2ec7a-22b5-11e4-bd33-17609cecca2f&
	 *          name=iso3&
	 *          value=PHL&
	 *          status=1&
	 *          editable=1&
	 *          visibility=1"
	 * 
	 * @apiDescription  Create a new Country Options
	 * @apiName         Post
	 * @apiGroup        Country Options
	 *
	 * @apiHeader       {String} X-COMPARE-REST-API-KEY   Country Options unique access-key.
	 *
	 * @apiParam        {String} language                 Mandatory Language.
	 * @apiParam        {String} countryCode              Mandatory Country code.
	 * @apiParam        {String} countryId                Mandatory Country ID of Country Options.
	 * @apiParam        {String} name                     Mandatory Name of the Country Options.
	 * @apiParam        {String} value                    Mandatory Value of the Country Options.
	 * @apiParam        {String} [label]                  Optional Label of the Country Options.
	 * @apiParam        {String} [editable=0]             Optional Editable Flag of the Country Options.
	 * @apiParam        {String} [visibility=0]           Optional Visibility Value of the Country Options.
	 * @apiParam        {String} [status=0]               Optional Status of the Country Options.
	 * @apiParam        {String} [createdBy]              Optional ID of the User who created the Country Options.
	 * @apiParam        {String} [modifiedBy]             Optional ID of the User who modified the Country Options.
	 *	
	 * @apiSuccess      {String} id                       The new Country-ID.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "594942d8-3815-11e4-b18a-fe7344fb1ea4"
	 *     }
	 *     
	 * @apiError BadInputParameter The request cannot be fulfilled due to bad syntax.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 400
	 *     {
	 *       "error": "BadInputParameter"
	 *     }
	 *     
	 * @apiError InvalidAccessToken The access token is invalid.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "InvalidAccessToken"
	 *     }
	 *
	 * @apiError MissingAuthenticationCredentials The authentication credentials are missing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "MissingAuthenticationCredentials"
	 *     }
	 *     
	 * @apiError RouteNotFound That route was not found on the server.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 
	 *     {
	 *       "error": "RouteNotFound"
	 *     }
	 */	
	public function post(){
		$results = array();
		$request = $this->di->get('request');
		$data = $request->getPost();
		if (!empty($data)){
			$countryOptions = new CountryOptions();
			$data['id'] = $countryOptions->id;
			$data['countryId'] = isset($data['countryId']) ? $data['countryId'] : '';
			$data['name'] = isset($data['name']) ? $data['name'] : '';
			$data['value'] = isset($data['value']) ? $data['value'] : '';
			$data['label'] = isset($data['label']) ? $data['label'] : '';
			$data['status'] = isset($data['status']) ? $data['status'] : 0;
			if (isset($data['status'])) {
				$data['active'] = ($data['status'] != CountryOptions::ACTIVE) ? 0 : 1 ;
				$data['editable'] = ($data['status'] != CountryOptions::ACTIVE) ? 0 : $data['editable'];
				$data['visibility'] = ($data['status'] != CountryOptions::ACTIVE) ? 0 : $data['visibility'];
			}
			$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
			$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';
			if ($countryOptions->save($data)){
				$results['id'] = $countryOptions->id;
			} else {
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $countryOptions->getMessages(),
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
		} else {
			throw new HTTPException(
				"The request cannot be fulfilled due to bad syntax.",
				400,
				array(
					'dev' => 'A required field is missing.',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}		
		return $results;
	}
	
	/**
	 * @api {delete} /country_options/:id DELETE /country_options/:id
	 * @apiExample Example usage:
	 * curl -i -X DELETE "http://apibeta.compargo.com/v1/country_options/594942d8-3815-11e4-b18a-fe7344fb1ea4	
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Delete a Country Option
	 * @apiName        Delete
	 * @apiGroup       Country Options
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Country Options unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Country Options Unique ID.
	 *
	 * @apiSuccess {String} id                       The ID of Country Options.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "594942d8-3815-11e4-b18a-fe7344fb1ea4"
	 *     } 
	 *     
	 * @apiError InvalidAccessToken The access token is invalid.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "InvalidAccessToken"
	 *     }
	 *
	 * @apiError MissingAuthenticationCredentials The authentication credentials are missing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "MissingAuthenticationCredentials"
	 *     }
	 * @apiError CountryOptionNotFound The id of the Country Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CountryOptionNotFound"
	 *     }
	 *     
	 * @apiError RouteNotFound That route was not found on the server.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 
	 *     {
	 *       "error": "RouteNotFound"
	 *     }    
	 */
	public function delete($id){
		$countryOptions = CountryOptions::findFirstById($id);
		if (!$countryOptions){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Country option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		} else {
			if ($countryOptions->delete()){
				$results['id'] = $countryOptions->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $countryOptions->getMessages(),
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
		}
		return $results;
	}
 	
	/**
	 * @api {put} /country_options/:id PUT /country_options/:id
	 * @apiExample Example usage:
	 * curl -i -X PUT "http://apibeta.compargo.com/v1/country_options/8c1291d6-22b9-11e4-bd33-17609cecca2f/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "name=numcode
	 *          value=004&
	 *          editable=1&
	 *          visibility=1&
	 *          status=1"
	 *      
	 * @apiDescription Update a Country Option
	 * @apiName  Put
	 * @apiGroup Country Options
	 *
	 * @apiHeader {String} X-COMPARE-REST-API-KEY   Country Options unique access-key.
	 *
	 * @apiParam  {String} language                 Mandatory Language.
	 * @apiParam  {String} countryCode              Mandatory Country Code.
	 * @apiParam  {String} id                       Mandatory Country Option Unique ID.
	 * @apiParam  {String} name                     Mandatory Name of the Country Option.
	 * @apiParam  {String} value                    Mandatory Value of the Country Option.
	 * @apiParam  {String} [label]                  Optional Label of the Country Option.
	 * @apiParam  {String} [editable]               Optional Editable Flag of the Country Option.
	 * @apiParam  {String} [visibility]             Optional Visibility Flag of the Country Option.
	 * @apiParam  {String} [status]                 Optional Status of the Country Option.
	 * @apiParam  {String} [createdBy]              Optional ID of the User who created the Country Option.
	 * @apiParam  {String} [modifiedBy]             Optional ID of the User who modified the Country Option.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "8c1291d6-22b9-11e4-bd33-17609cecca2f"
	 *     }
	 *     
	 * @apiError BadInputParameter The request cannot be fulfilled due to bad syntax.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 400
	 *     {
	 *       "error": "BadInputParameter"
	 *     }
	 *          
	 * @apiError InvalidAccessToken The access token is invalid.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "InvalidAccessToken"
	 *     }
	 *
	 * @apiError MissingAuthenticationCredentials The authentication credentials are missing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "MissingAuthenticationCredentials"
	 *     }
	 * @apiError CountryOptionNotFound The id of the Country Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CountryOptionNotFound"
	 *     }
	 */
	public function put($id){
		$results = array();
		$request = $this->di->get('request');
		$data = $request->getPut();
		if (!empty($data)){
			$countryOptions = CountryOptions::findFirstById($id);
			if (!$countryOptions){
				throw new HTTPException(
					"Not found",
					404,
					array(
							'dev' => 'Country option does not exist',
							'internalCode' => 'P1000',
							'more' => '' // Could have link to documentation here.
					)
				);
			} else {
				$params['countryId'] = isset($data['countryId']) ? $data['countryId'] : $countryOptions->countryId;
				$params['name'] = isset($data['name']) ? $data['name'] : $countryOptions->name;
				$params['value'] = isset($data['value']) ? $data['value'] : $countryOptions->value;
				$params['label'] = isset($data['label']) ? $data['label'] : $countryOptions->label;
				$data['status'] = isset($data['status']) ? $data['status'] : $countryOptions->status;
				if (isset($data['status'])) {
					$data['active'] = ($data['status'] != CountryOptions::ACTIVE) ? 0 : 1 ;
					$data['editable'] = ($data['status'] != CountryOptions::ACTIVE) ? 0 : $countryOptions->editable;
					$data['visibility'] = ($data['status'] != CountryOptions::ACTIVE) ? 0 : $countryOptions->visibility;
				}
				$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : $countryOptions->createdBy;
				$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] :  $countryOptions->modifiedBy;
				if ($countryOptions->save($data)){
					$results['id'] = $countryOptions->id;
				}else{
					throw new HTTPException(
						"Request unable to be followed due to semantic errors",
						422,
						array(
							'dev' => $countryOptions->getMessages(),
							'internalCode' => 'P1000',
							'more' => '' // Could have link to documentation here.
						)
					);
				}
			}
		} else {
			
		}
		return $results;
	}
	
	/**
	 * @api {post} /country_options/search POST /country_options/search
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/country_options/search/?countryCode=ph&language=en"
	 *      -d "query={"status":"1"}&fields=id,countryId,name,value,label,editable,visibility,status&
	 *          sort=id,name&
	 *          limit=10"
	 *
	 * @apiDescription Read data of all Country Options
	 * @apiName        Search
	 * @apiGroup       Country Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Country Options unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} [query]                  Optional query conditions that rows must satisfy to be selected.
	 * @apiParam       {String} [fields]                 Optional field indicates a column that you want to retrieve.
	 * @apiParam       {String} [sort]                   Optional sort orders columns selected for output.
	 * @apiParam       {String} [limit=0]                Optional limit used to constrain the number of rows returned.
	 * 													 When offset parameter is present, the limit specifies the offset
	 *                                                   of the first row to return. When count parameter exists, the limit 
	 *                                                   identifies all the rows returned and with default 0.
	 * @apiParam       {String} [offset]                 Optional offset specifies the maximum number of rows to return.
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of country options.
	 * 
	 * @apiSuccess     {String} id                       ID of the Country Options. 
	 * @apiSuccess     {String} countryId                Country ID of the Country Options. 
	 * @apiSuccess     {String} name                     Name of the Channels Options. 
	 * @apiSuccess     {String} value                    Value of the Channels Options. 
	 * @apiSuccess     {String} label                    Label of the Channels Options.
	 * @apiSuccess     {String} editable                 Editable Flag of the Country Options. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Country Options.  
	 * @apiSuccess     {Number} status                   Status Flag of the Country Options. 
	 * @apiSuccess     {Number} active                   Active Flag of the Country Options. 
	 * @apiSuccess     {Date}   created                  Creation date of the Country Options. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Country Options. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Country Options. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Country Options. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "1535ebcc-22b8-11e4-bd33-17609cecca2f",
     *       "name": "iso2",
     *       "description": "",
     *       "editable": "1",
     *       "visibility": "1",
     *       "status": "1"
     *     },
	 *     {
     *       "id": "1535ebcc-22b8-11e4-bd33-17609cecca2f",
     *       "name": "shortname",
     *       "description": "",
     *       "editable": "1",
     *       "visibility": "1",
     *       "status": "1"	
     *     }
	 *
	 * @apiError InvalidAccessToken The access token is invalid.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "InvalidAccessToken"
	 *     }
	 *
	 * @apiError MissingAuthenticationCredentials The authentication credentials are missing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "MissingAuthenticationCredentials"
	 *     }
	 *     
	 * @apiError WrongFieldsReturned The requested fields are not available.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "WrongFieldsReturned"
	 *     }     
	 */
	public function search(){
		$countryOptions = new CountryOptionsCollection($this->di);
		return $this->respond($countryOptions);
	}
	
	/**
	 * @api {post} /country_options/search/:id POST /country_options/search/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -i "http://apibeta.compargo.com/v1/country_options/search/05a5ec26-372a-11e4-b18a-fe7344fb1ea4/?countryCode=ph&language=en"
	 *
	 * @apiDescription Read data of a Countries Options
	 * @apiName        SearchOne
	 * @apiGroup       Country Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Country Options unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Countries Options unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Country Options.
	 * @apiSuccess     {String} countryId                Country ID of the Country Options.
	 * @apiSuccess     {String} name                     Name of the Channels Options.
	 * @apiSuccess     {String} value                    Value of the Channels Options.
	 * @apiSuccess     {String} label                    Label of the Channels Options.
	 * @apiSuccess     {String} editable                 Editable Flag of the Country Options.
	 * @apiSuccess     {String} visibility               Visibility Flag of the Country Options.
	 * @apiSuccess     {Number} status                   Status Flag of the Country Options.
	 * @apiSuccess     {Number} active                   Active Flag of the Country Options.
	 * @apiSuccess     {Date}   created                  Creation date of the Country Options.
	 * @apiSuccess     {Date}   modified                 Modification date of the Country Options.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Country Options.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Country Options.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "1535ebcc-22b8-11e4-bd33-17609cecca2f",
	 *       "name": "iso2",
	 *       "description": "",
	 *       "editable": "1",
	 *       "visibility": "1",
	 *       "status": "1"
	 *     }
	 *
	 * @apiError CountryOptionNotFound The id of the Country Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CountryOptionNotFound"
	 *     }
	 *
	 * @apiError InvalidAccessToken The access token is invalid.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "InvalidAccessToken"
	 *     }
	 *
	 * @apiError MissingAuthenticationCredentials The authentication credentials are missing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "MissingAuthenticationCredentials"
	 *     }
	 *
	 * @apiError RouteNotFound That route was not found on the server.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404
	 *     {
	 *       "error": "RouteNotFound"
	 *     }
	 */
	public function searchOne($id){
		$results = array();
		$request = $this->di->get('requestBody');
		$parameters = $request->get();
		if (count($parameters) > 1) {
			$countryOptions = new CountryOptionsCollection($this->di);
			$results = $this->respond($countryOptions, $id);
		}else{
			$results = CountryOptionsCollection::find(array(
				array("id" => $id)
			));
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Country option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
}