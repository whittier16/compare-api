<?php
namespace App\Modules\Backend\Controllers;

use App\Modules\Backend\Models\Country as Country,
	App\Modules\Frontend\Models\Country as CountryCollection,
    App\Common\Lib\Application\Controllers\RESTController,
    App\Common\Lib\Application\Exceptions\HTTPException;


class CountryController extends RESTController{

	/**
	 * Sets which fields may be searched against, and which fields are allowed to be returned in
	 * partial responses. 
	 * @var array
	 */
	protected $allowedFields = array(
		'search' => array(
				'id',
				'name', 
				'description',
				'status',
				'active',
				'created',
				'modified',
				'createdBy',
				'modifiedBy'
		),
		'partials' => array(
				'id',
				'name', 
				'description',
				'status',
				'active',
				'created',
				'modified',
				'createdBy',
				'modifiedBy'
		),
		'sort' => array(
				'id',
				'name',
				'description',
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
	protected $allowedObjects = array();
	
	/**
	 * Country constructor
	 */
	public function __construct(){
		parent::__construct(false);
		$this->parseRequest($this->allowedFields, $this->allowedObjects);
	}
	
	/**
	 * @api {get} /country GET /country
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/country/?countryCode=ph&language=en&
	 *          query={"status":"1"}&
	 *          fields=id,name,description,status,active,created,modified,createdBy,modifiedBy&
	 *          sort=id,name&
	 *          limit=10"
	 *
	 * @apiDescription Read data of a Country
	 * @apiName        Get
	 * @apiGroup       Country
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Area unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of country.
	 * 
	 * @apiSuccess     {String} id                       ID of the Country. 
	 * @apiSuccess     {String} name                     Name of the Country.
	 * @apiSuccess     {String} description              Description of the Country.
	 * @apiSuccess     {Number} status                   Status Flag of the Country.
	 * @apiSuccess     {Number} active                   Active Flag of the Country.
	 * @apiSuccess     {Date}   created                  Creation date of the Country.
	 * @apiSuccess     {Date}   modified                 Modification date of the Country.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Country.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Country.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "4de2ec7a-22b5-11e4-bd33-17609cecca2f",
     *       "name": "Philippines",
     *       "description": "",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-13 08:44:42",
     *       "modified": "0000-00-00 00:00:00",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
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
		$country = new CountryCollection($this->di);
		return $this->respond($country);
	}
	
	/**
	 * @api {get} /country/:id GET /country/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/country/4de2ec7a-22b5-11e4-bd33-17609cecca2f/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Country
	 * @apiName        GetOne
	 * @apiGroup       Country
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Country unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Country unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Country.
	 * @apiSuccess     {String} name                     Name of the Country.
	 * @apiSuccess     {String} alias                    Alias of the Country.
	 * @apiSuccess     {String} description              Description of the Country.
	 * @apiSuccess     {Number} status                   Status of the Country.
     * @apiSuccess     {Number} active                   Flag of the Country.
	 * @apiSuccess     {Date}   created                  Creation date of the Country.
	 * @apiSuccess     {Date}   modified                 Modification date of the Country.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Country.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Country.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "4de2ec7a-22b5-11e4-bd33-17609cecca2f",
     *       "name": "Philippines",
     *       "description": "",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-13 08:44:42",
     *       "modified": "0000-00-00 00:00:00",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     }
	 *
	 * @apiError CountryNotFound The id of the Country was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CountryNotFound"
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
	 *     
	 */	
	public function getOne($id){
		$request = $this->di->get('request');
		$parameters = $request->get();
		if (count($parameters) > 1) {
			$country = new CountryCollection($this->di);
			$results = $this->respond($country, $id);
		}else{
			$results = CountryCollection::find(array(
				array("id" => $id)
			));
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Country does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * @api {post} /country POST /country
     * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/country/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "name=Philippines&
	 *          description=Philippines&
	 *          status=1"
	 * 
	 * @apiDescription  Create a new Country
	 * @apiName         Post
	 * @apiGroup        Country
	 *
	 * @apiHeader       {String} X-COMPARE-REST-API-KEY   Country unique access-key.
	 *
	 * @apiParam        {String} language                 Mandatory Language.
	 * @apiParam        {String} countryCode              Mandatory Country code.
	 * @apiParam        {String} name                     Mandatory Name of the Country.
	 * @apiParam        {String} [description]            Optional Description of the Country.
	 * @apiParam        {String} [alias]                  Optional Alias of the Country.
	 * @apiParam        {String} [status=0]               Optional Status of the Country.
	 * @apiParam        {String} [createdBy]              Optional ID of the User who created the Country.
	 * @apiParam        {String} [modifiedBy]             Optional ID of the User who modified the Country.
	 * 
	 * @apiSuccess      {String} id                       The new Country-ID.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "a33f2342-37c7-11e4-b18a-fe7344fb1ea4"
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
			$country = new Country();
			$data['id'] = $country->id;
			$data['name'] = isset($data['name']) ? $data['name'] : '';
			$data['description'] = isset($data['description']) ? $data['description'] : '';
			$data['status'] = isset($data['status']) ? $data['status'] : 0;
			if (isset($data['status'])) {
				$data['active'] = ($data['status'] != Country::ACTIVE) ? 0 : 1 ;
			}
			$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
			$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';
			if ($country->save($data)){
				$results['id'] = $country->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $country->getMessages(),
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
	 * @api {delete} /country/:id DELETE /country/:id
	 * @apiExample Example usage:
	 * curl -i -X DELETE "http://apibeta.compargo.com/v1/country/07f44e24-1d43-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Delete a Country
	 * @apiName        Delete
	 * @apiGroup       Country
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Country unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Country Unique ID.
	 *
	 * @apiSuccess {String} id                       The ID of Country.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "1535ebcc-22b8-11e4-bd33-17609cecca2f"
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
	 * @apiError CountryNotFound The id of the Country was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CountryNotFound"
	 *     }
	 *     
	 * @apiError RouteNotFound That route was not found on the server.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 
	 *     {
	 *       "error": "RouteNotFound"
	 *     } 
	 *     
	 */
	public function delete($id){
		$country = Country::findFirstById($id);
		if (!$country){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Country does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		} else {
			if ($country->delete()){
				$results['id'] = $country->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $country->getMessages(),
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
		}
		return $results;
	}
 	
	/**
	 * @api {put} /country/:id PUT /country/:id
	 * @apiExample Example usage:
	 * curl -i -X PUT "http://apibeta.compargo.com/v1/country/07f44e24-1d43-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "name=Philippines&description=&status=1"
	 *      
	 * @apiDescription Update a Country
	 * @apiName  Put
	 * @apiGroup Country
	 *
	 * @apiHeader {String} X-COMPARE-REST-API-KEY   Country unique access-key.
	 *
	 * @apiParam  {String} language                 Mandatory Language.
	 * @apiParam  {String} countryCode              Mandatory Country Code.
	 * @apiParam  {String} id                       Mandatory Country Unique ID.
	 * @apiParam  {String} name                     Mandatory Name of the Country.
	 * @apiParam  {String} [description]            Optional Description of the Country.
	 * @apiParam  {String} [status]                 Optional Status of the Country.
	 * @apiParam  {String} [createdBy]              Optional ID of the User who created the Country.
	 * @apiParam  {String} [modifiedBy]             Optional ID of the User who modified the Country.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "07f44e24-1d43-11e4-b32d-eff91066cccf"
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
	 * @apiError CountryNotFound The id of the Country was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CountryNotFound"
	 *     }
	 */
	public function put($id){
		$results = array();
		$request = $this->di->get('request');
		$data = $request->getPut();
		
		if (!empty($data)){
			$country = Country::findFirst($id);
			if (!$country){
				throw new HTTPException(
					"Not found",
					404,
					array(
						'dev' => 'Country does not exist',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			} else {
				$data['name'] = isset($data['name']) ? $data['name'] : $country->name;
				$data['description'] = isset($data['description']) ? $data['description'] : $country->description;
				$data['status'] = isset($data['status']) ? $data['status'] : $country->status;
				if (isset($data['status'])) {
					$data['active'] = ($data['status'] != Country::ACTIVE) ? 0 : 1 ;
				}
				$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : $country->createdBy;
				$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : $country->createdBy;
				if ($country->save($data)){
					$results['id'] = $country->id;
				}else{
					throw new HTTPException(
						"Request unable to be followed due to semantic errors",
						422,
						array(
							'dev' => $country->getMessages(),
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
	 * @api {post} /country/search POST /country/search
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/country/search/?countryCode=ph&language=en"
	 *      -d "query={"status":"1"}&
	 *          fields=id,name,description,status,active,created,modified,createdBy,modifiedBy&
	 *          sort=id,name&
	 *          limit=10"
	 *
	 * @apiDescription Read data of a Country
	 * @apiName        Search
	 * @apiGroup       Country
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Area unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of country.
	 * 
	 * @apiSuccess     {String} id                       ID of the Country. 
	 * @apiSuccess     {String} name                     Name of the Country.
	 * @apiSuccess     {String} description              Description of the Country.
	 * @apiSuccess     {Number} status                   Status Flag of the Country.
	 * @apiSuccess     {Number} active                   Active Flag of the Country.
	 * @apiSuccess     {Date}   created                  Creation date of the Country.
	 * @apiSuccess     {Date}   modified                 Modification date of the Country.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Country.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Country.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "4de2ec7a-22b5-11e4-bd33-17609cecca2f",
     *       "name": "Philippines",
     *       "description": "",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-13 08:44:42",
     *       "modified": "0000-00-00 00:00:00",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
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
		$country = new CountryCollection($this->di);
		return $this->respond($country);
	}
	
	/**
	 * @api {get} /country/search/:id GET /country/search/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/country/search/4de2ec7a-22b5-11e4-bd33-17609cecca2f/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Country
	 * @apiName        SearchOne
	 * @apiGroup       Country
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Country unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Country unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Country.
	 * @apiSuccess     {String} name                     Name of the Country.
	 * @apiSuccess     {String} alias                    Alias of the Country.
	 * @apiSuccess     {String} description              Description of the Country.
	 * @apiSuccess     {Number} status                   Status of the Country.
     * @apiSuccess     {Number} active                   Flag of the Country.
	 * @apiSuccess     {Date}   created                  Creation date of the Country.
	 * @apiSuccess     {Date}   modified                 Modification date of the Country.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Country.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Country.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "4de2ec7a-22b5-11e4-bd33-17609cecca2f",
     *       "name": "Philippines",
     *       "description": "",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-13 08:44:42",
     *       "modified": "0000-00-00 00:00:00",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     }
	 *
	 * @apiError CountryNotFound The id of the Country was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CountryNotFound"
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
	 *     
	 */	
	public function searchOne($id){
		$results = array();
		$request = $this->di->get('requestBody');
		$parameters = $request->get();
		if (count($parameters) > 1) {
			$country = new CountryCollection($this->di);
			$results = $this->respond($country, $id);
		}else{
			$results = CountryCollection::find(array(
				array("id" => $id)
			));
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Country does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
}