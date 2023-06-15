<?php
namespace App\Modules\Backend\Controllers;

use App\Modules\Backend\Models\CompaniesOptions,
	App\Modules\Frontend\Models\CompaniesOptions as CompaniesOptionsCollection,
	App\Common\Lib\Application\Controllers\RESTController,
	App\Common\Lib\Application\Exceptions\HTTPException;


class CompaniesOptionsController extends RESTController{

	/**
	 * Sets which fields may be searched against, and which fields are allowed to be returned in
	 * partial responses. 
	 * @var array
	 */
	protected $allowedFields = array(
		'search' => array(
				'id',
				'modelId',
				'category',
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
				'modelId',
				'category',
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
				'modelId',
				'category',
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
	protected $allowedObjects = array();
	
	/**
	 * Companies Options constructor
	 */
	public function __construct(){
		parent::__construct(false, false);
		$this->parseRequest($this->allowedFields, $this->allowedObjects);
		$this->schemaDir = __DIR__ . $this->getDI()->getConfig()->application->jsonSchemaDir;
	}
	
	/**
	 * @api {get} /companies_options GET /companies_options
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/companies_options/?countryCode=ph&language=en&
	 *          query={"status":"1"}&fields=id,modelId,category,name,value,label,editable,visibility,status&
	 *          sort=-id,category,name&
	 *          limit=20"
	 *
	 * @apiDescription Read data of all Companies Options
	 * @apiName        Get
	 * @apiGroup       Companies Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Companies Options unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of companies options.
	 * 
	 * @apiSuccess     {String} id                       ID of the Companies Options. 
	 * @apiSuccess     {String} modelId                  Brand ID/Company ID of the Companies Options.
	 * @apiSuccess     {String} category                 Brand/Company Category of the Companies Options. 
	 * @apiSuccess     {String} name                     Name of the Companies Options. 
	 * @apiSuccess     {String} value                    Value of the Companies Options. 
	 * @apiSuccess     {String} label                    Label of the Companies Options.
	 * @apiSuccess     {String} editable                 Editable Flag of the Companies Options. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Companies Options.  
	 * @apiSuccess     {Number} status                   Status Flag of the Companies Options. 
	 * @apiSuccess     {Number} active                   Active Flag of the Companies Options. 
	 * @apiSuccess     {Date}   created                  Creation date of the Companies Options. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Companies Options. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Companies Options. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Companies Options. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "8a048714-2791-11e4-bd33-17609cecca2f",
     *       "modelId": "10f0c896-2134-11e4-bb06-0a68ec684316",
     *       "category": "company",
     *       "name": "fax",
     *       "value": "123456789",
     *       "label": "",
     *       "editable": "0",
     *       "visibility": "0",
     *       "status": "1"
     *     },
	 *     {
	 *       "id": "6916ee92-2805-11e4-bd33-17609cecca2f",
     *       "modelId": "10f0c896-2134-11e4-bb06-0a68ec684316",
     *       "category": "company",
     *       "name": "phone",
     *       "value": "6775467897",
     *       "label": "",
     *       "editable": "0",
     *       "visibility": "0",
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
		$companiesOptions = new CompaniesOptionsCollection($this->di);
		return $this->respond($companiesOptions);
	}
	
	/**
	 * @api {get} /companies_options/:id GET /companies_options/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/companies_options/05a5ec26-372a-11e4-b18a-fe7344fb1ea4/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Companies Options
	 * @apiName        GetOne
	 * @apiGroup       Companies Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Companies Options unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Companies Options unique ID.
	 *
 	 * @apiSuccess     {String} id                       ID of the Companies Option.
	 * @apiSuccess     {String} modelId                  Brand ID/Company ID of the Companies Option.
	 * @apiSuccess     {String} category                 Brand/Company Category of the Companies Option.
	 * @apiSuccess     {String} name                     Name of the Companies Option.
	 * @apiSuccess     {String} value                    Value of the Companies Option.
	 * @apiSuccess     {String} label                    Label of the Companies Option.
	 * @apiSuccess     {String} editable                 Editable Flag of the Companies Option. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Companies Option.  
	 * @apiSuccess     {Number} status                   Status Flag of the Companies Option. 
	 * @apiSuccess     {Number} active                   Active Flag of the Companies Option. 
	 * @apiSuccess     {Date}   created                  Creation date of the Companies Option. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Companies Option. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Companies Option. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Companies Option. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "8a048714-2791-11e4-bd33-17609cecca2f",
     *       "modelId": "10f0c896-2134-11e4-bb06-0a68ec684316",
     *       "category": "company",
     *       "name": "fax",
     *       "value": "123456789",
     *       "label": "",
     *       "editable": "0",
     *       "visibility": "0",
     *       "status": "1"
     *     }
	 *
	 * @apiError CompaniesOptionNotFound The id of the Companies Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CompaniesOptionNotFound"
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
			$companiesOptions = new CompaniesOptionsCollection($this->di);
			$results = $this->respond($companiesOptions, $id);
		}else{
			$results = CompaniesOptionsCollection::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Companies option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * @api {post} /companies_options POST /companies_options
     * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/companies_options/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "modelId=10f0c896-2134-11e4-bb06-0a68ec684316&
	 *          category=company&
	 *          name=address&
	 *          value=4th Floor-Ayala Wing, BPI Head Office, Ayala Ave cor Paseo de Roxas, Makati City&
	 *          status=1&
	 *          editable=1&
	 *          visibility=1"
	 * 
	 * @apiDescription  Create a new Companies Options
	 * @apiName         Post
	 * @apiGroup        Companies Options
	 *
	 * @apiHeader       {String} X-COMPARE-REST-API-KEY   Companies Options unique access-key.
	 *
	 * @apiParam        {String} language                 Mandatory Language.
	 * @apiParam        {String} countryCode              Mandatory Country code.
	 * @apiParam        {String} modelId                  Mandatory Brand ID/Company ID of Companies Options.
	 * @apiParam        {String} category                 Mandatory Brand/Company Category of Companies Options.
	 * @apiParam        {String} name                     Mandatory Name of the Companies Options.
	 * @apiParam        {String} value                    Mandatory Value of the Companies Options.
	 * @apiParam        {String} [label]                  Optional Label of the Companies Options.
	 * @apiParam        {String} [editable=0]             Optional Editable Flag of the Companies Options.
	 * @apiParam        {String} [visibility=0]           Optional Visibility Value of the Companies Options.
	 * @apiParam        {String} [status=0]               Optional Status of the Companies Options.
	 * @apiParam        {String} [createdBy]              Optional ID of the User who created the Companies Options.
	 * @apiParam        {String} [modifiedBy]             Optional ID of the User who modified the Companies Options.
	 *	
	 * @apiSuccess      {String} id                       The new Channel-ID.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "96b3d052-3716-11e4-b18a-fe7344fb1ea4"
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
		$data = $request->get();
		
		if (!empty($data)) {
			$companiesOptions = new CompaniesOptions();
			$data['id'] = $companiesOptions->id;
			$data['modelId'] = isset($data['modelId']) ? $data['modelId'] : '';
			$data['category'] = isset($data['category']) ? $data['category'] : '';
			$data['name'] = isset($data['name']) ? $data['name'] : '';
			$data['value'] = isset($data['value']) ? $data['value'] : '';
			$data['label'] = isset($data['label']) ? $data['label'] : '';
			$data['status'] = isset($data['status']) ? $data['status'] : 0;
			if (isset($data['status'])) {
				$data['active'] = ($data['status'] != CompaniesOptions::ACTIVE) ? 0 : 1 ;
				$data['editable'] = ($data['status'] != CompaniesOptions::ACTIVE) ? 0 : isset($data['editable']) ? $data['editable'] : 0 ; 
				$data['visibility'] = ($data['status'] != CompaniesOptions::ACTIVE) ? 0 : isset($data['visibility']) ? $data['visibility'] : 0 ;
			}
			$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
			$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';

			$params[$data['name']] = $data['value'];
			$valid = $companiesOptions->validateProperty($params, $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->companies);

			if (!empty($valid)) {
				$errors = implode(", ", $valid);
				throw new HTTPException(
						"Request unable to be followed due to semantic errors.",
						422,
						array(
								'dev'=> ucfirst($errors),
								'internalCode' => 'P1000',
								'more' => ''
						)
				);
			}
						
			if ($companiesOptions->create($data)){
				$results['id'] = $companiesOptions->id;
			} else {
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $companiesOptions->getMessages(),
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
	 * @api {delete} /companies_options/:id DELETE /companies_options/:id
	 * @apiExample Example usage:
	 * curl -i -X DELETE "http://apibeta.compargo.com/v1/companies_options/delete/6916ee92-2805-11e4-bd33-17609cecca2f	
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Delete a Companies Option
	 * @apiName        Delete
	 * @apiGroup       Companies Options
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Companies Options unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Companies Option Unique ID.
	 *
	 * @apiSuccess {String} id                       The ID of Companies Option.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "6916ee92-2805-11e4-bd33-17609cecca2f"
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
	 * @apiError CompaniesOptionNotFound The id of the Companies Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CompaniesOptionNotFound"
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
		$companiesOptions = CompaniesOptions::findFirstById($id);
		if (!$companiesOptions){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Companies option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		} else {
			if ($companiesOptions->delete()){
				$results['id'] = $companiesOptions->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $companiesOptions->getMessages(),
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
		}
		return $results;
	}
 	
	/**
	 * @api {put} /companies_options/:id PUT /companies_options/:id
	 * @apiExample Example usage:
	 * curl -i -X PUT "http://apibeta.compargo.com/v1/companies_options/8a048714-2791-11e4-bd33-17609cecca2f/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "category=brand&
	 *          value=1234567&
	 *          editable=1&
	 *          visibility=1&
	 *          status=0"
	 *      
	 * @apiDescription Update a Companies Option
	 * @apiName  Put
	 * @apiGroup Companies Options
	 *
	 * @apiHeader {String} X-COMPARE-REST-API-KEY   Companies Options unique access-key.
	 *
	 * @apiParam  {String} language                 Mandatory Language.
	 * @apiParam  {String} countryCode              Mandatory Country Code.
	 * @apiParam  {String} id                       Mandatory Companies Option Unique ID.
	 * @apiParam  {String} modelId                  Mandatory Company ID/Brand ID of the Companies Option.
	 * @apiParam  {String} category                 Mandatory Company/Model ID of the Companies Option.
	 * @apiParam  {String} name                     Mandatory Name of the Companies Option.
	 * @apiParam  {String} value                    Mandatory Value of the Companies Option.
	 * @apiParam  {String} [label]                  Optional Label of the Companies Option.
	 * @apiParam  {String} [editable]               Optional Editable Flag of the Companies Option.
	 * @apiParam  {String} [visibility]             Optional Visibility Flag of the Companies Option.
	 * @apiParam  {String} [status]                 Optional Status of the Companies Option.
	 * @apiParam  {String} [createdBy]              Optional ID of the User who created the Companies Option.
	 * @apiParam  {String} [modifiedBy]             Optional ID of the User who modified the Companies Option.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "8a048714-2791-11e4-bd33-17609cecca2f"
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
	 * @apiError CompaniesOptionNotFound The id of the Companies Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CompaniesOptionNotFound"
	 *     }
	 */
	public function put($id){
		$results = $params = array();
		$request = $this->di->get('request');
		$data = $request->getPut();
		
		if (!empty($data)){
			$companiesOptions = CompaniesOptions::findFirstById($id);
			if (!$companiesOptions){
				throw new HTTPException(
					"Not found",
					404,
					array(
						'dev' => 'Companies option does not exist',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			} else {
				$data['modelId'] = isset($data['modelId']) ? $data['modelId'] : $companiesOptions->modelId;
				$data['category'] = isset($data['category']) ? $data['category'] : $companiesOptions->category;
				$data['name'] = isset($data['name']) ? $data['name'] : $companiesOptions->name;
				$data['value'] = isset($data['value']) ? $data['value'] : $companiesOptions->value;
				$data['label'] = isset($data['label']) ? $data['label'] : $companiesOptions->label;
				$data['status'] = isset($data['status']) ? $data['status'] : $companiesOptions->status;
				if (isset($data['status'])) {
					$data['active'] = ($data['status'] != CompaniesOptions::ACTIVE) ? 0 : 1 ;
					$data['editable'] = ($data['status'] != CompaniesOptions::ACTIVE) ? 0 : $companiesOptions->editable;
					$data['visibility'] = ($data['status'] != CompaniesOptions::ACTIVE) ? 0 : $companiesOptions->visibility;
				} 
				$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : $companiesOptions->createdBy;
				$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : $companiesOptions->modifiedBy;
				
				if ($companiesOptions->save($data)){
					$results['id'] = $companiesOptions->id;
				}else{
					throw new HTTPException(
						"Request unable to be followed due to semantic errors",
						422,
						array(
							'dev' => $companiesOptions->getMessages(),
							'internalCode' => 'P1000',
							'more' => '' // Could have link to documentation here.
						)
					);
				}
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
	 * @api {post} /companies_options POST /companies_options
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i -X POST "http://apibeta.compargo.com/v1/companies_options/?countryCode=ph&language=en"
	 *      -D "query={"status":"1"}&fields=id,modelId,category,name,value,label,editable,visibility,status&
	 *          sort=-id,category,name&
	 *          limit=20"
	 *
	 * @apiDescription Read data of all Companies Options
	 * @apiName        Search
	 * @apiGroup       Companies Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Companies Options unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of companies options.
	 * 
	 * @apiSuccess     {String} id                       ID of the Companies Options. 
	 * @apiSuccess     {String} modelId                  Brand ID/Company ID of the Companies Options.
	 * @apiSuccess     {String} category                 Brand/Company Category of the Companies Options. 
	 * @apiSuccess     {String} name                     Name of the Companies Options. 
	 * @apiSuccess     {String} value                    Value of the Companies Options. 
	 * @apiSuccess     {String} label                    Label of the Companies Options.
	 * @apiSuccess     {String} editable                 Editable Flag of the Companies Options. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Companies Options.  
	 * @apiSuccess     {Number} status                   Status Flag of the Companies Options. 
	 * @apiSuccess     {Number} active                   Active Flag of the Companies Options. 
	 * @apiSuccess     {Date}   created                  Creation date of the Companies Options. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Companies Options. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Companies Options. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Companies Options. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "8a048714-2791-11e4-bd33-17609cecca2f",
     *       "modelId": "10f0c896-2134-11e4-bb06-0a68ec684316",
     *       "category": "company",
     *       "name": "fax",
     *       "value": "123456789",
     *       "label": "",
     *       "editable": "0",
     *       "visibility": "0",
     *       "status": "1"
     *     },
	 *     {
	 *       "id": "6916ee92-2805-11e4-bd33-17609cecca2f",
     *       "modelId": "10f0c896-2134-11e4-bb06-0a68ec684316",
     *       "category": "company",
     *       "name": "phone",
     *       "value": "6775467897",
     *       "label": "",
     *       "editable": "0",
     *       "visibility": "0",
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
		$companiesOptions = new CompaniesOptionsCollection($this->di);
		return $this->respond($companiesOptions);
	}
	
	/**
	 * @api {post} /companies_options/:id POST /companies_options/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i -X POST "http://apibeta.compargo.com/v1/companies_options/05a5ec26-372a-11e4-b18a-fe7344fb1ea4/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Companies Options
	 * @apiName        SearchOne
	 * @apiGroup       Companies Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Companies Options unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Companies Options unique ID.
	 *
 	 * @apiSuccess     {String} id                       ID of the Companies Option.
	 * @apiSuccess     {String} modelId                  Brand ID/Company ID of the Companies Option.
	 * @apiSuccess     {String} category                 Brand/Company Category of the Companies Option.
	 * @apiSuccess     {String} name                     Name of the Companies Option.
	 * @apiSuccess     {String} value                    Value of the Companies Option.
	 * @apiSuccess     {String} label                    Label of the Companies Option.
	 * @apiSuccess     {String} editable                 Editable Flag of the Companies Option. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Companies Option.  
	 * @apiSuccess     {Number} status                   Status Flag of the Companies Option. 
	 * @apiSuccess     {Number} active                   Active Flag of the Companies Option. 
	 * @apiSuccess     {Date}   created                  Creation date of the Companies Option. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Companies Option. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Companies Option. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Companies Option. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "8a048714-2791-11e4-bd33-17609cecca2f",
     *       "modelId": "10f0c896-2134-11e4-bb06-0a68ec684316",
     *       "category": "company",
     *       "name": "fax",
     *       "value": "123456789",
     *       "label": "",
     *       "editable": "0",
     *       "visibility": "0",
     *       "status": "1"
     *     }
	 *
	 * @apiError CompaniesOptionNotFound The id of the Companies Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CompaniesOptionNotFound"
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
			$companiesOptions = new CompaniesOptionsCollection($this->di);
			$results = $this->respond($companiesOptions, $id);
		}else{
			$results = CompaniesOptionsCollection::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Companies option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
}