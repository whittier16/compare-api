<?php
namespace App\Modules\Backend\Controllers;

use App\Modules\Backend\Models\ProductsOptions,
	App\Modules\Backend\Models\Products,
	App\Modules\Backend\Models\Channels,
	App\Modules\Frontend\Models\ProductsOptions as ProductsOptionsCollection,
	App\Common\Lib\Application\Controllers\RESTController,
	App\Common\Lib\Application\Exceptions\HTTPException;


class ProductsOptionsController extends RESTController{

	/**
	 * Sets which fields may be searched against, and which fields are allowed to be returned in
	 * partial responses. 
	 * @var array
	 */
	protected $allowedFields = array(
		'search' => array(
				'id',
				'productId',
				'areaId',
				'name', 
				'value', 
				'label',
				'status',
				'active',	
				'created',
				'modified',
				'createdBy',
				'modifiedBy'
		),
		'partials' => array(
				'id',
				'productId',
				'areaId',
				'name', 
				'value', 
				'label',
				'status',
				'active',	
				'created',
				'modified',
				'createdBy',
				'modifiedBy'
		),
		'sort' => array(
				'id',
				'productId',
				'areaId',
				'name', 
				'value', 
				'label',
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
	
	protected $schemaDir;
	
	/**
	 * Products Options constructor
	 */
	public function __construct(){
		parent::__construct(false, false);
		$this->parseRequest($this->allowedFields, $this->allowedObjects);
		$this->schemaDir = __DIR__ . $this->getDI()->getConfig()->application->jsonSchemaDir;
	}
	
	/**
	 * @api {get} /products_options GET /products_options
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/products_options/?countryCode=ph&language=en&
	 *          query={"status":"1"}&fields=id,productId,areaId,name,value,label,editable,visibility,status&
	 *          sort=-id,name&
	 *          limit=20"
	 *
	 * @apiDescription Read data of all Products Options
	 * @apiName        Get
	 * @apiGroup       Products Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Products Options unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of products options.
	 * 
	 * @apiSuccess     {String} id                       ID of the Products Options. 
	 * @apiSuccess     {String} productId                Product ID of the Products Options.
	 * @apiSuccess     {String} areaId                   Area ID of the Products Options. 
	 * @apiSuccess     {String} name                     Name of the Products Options. 
	 * @apiSuccess     {String} value                    Value of the Products Options. 
	 * @apiSuccess     {String} label                    Label of the Products Options.
	 * @apiSuccess     {String} editable                 Editable Flag of the Products Options. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Products Options.  
	 * @apiSuccess     {Number} status                   Status Flag of the Products Options. 
	 * @apiSuccess     {Number} active                   Active Flag of the Products Options. 
	 * @apiSuccess     {Date}   created                  Creation date of the Products Options. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Products Options. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Products Options. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Products Options. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
     *       "id": "e36429f8-3a61-11e4-b18a-fe7344fb1ea4",
     *       "productId": "6de2478a-3a45-11e4-b18a-fe7344fb1ea4",
     *       "areaId": "0b412a0e-397a-11e4-b18a-fe7344fb1ea4",
     *       "name": "minimumAgeSupplementary",
     *       "value": "13",
     *       "label": null,
     *       "editable": null,
     *       "visibility": null,
     *       "status": "1"
     *   },
     *   {
     *       "id": "e7ddeeba-3a61-11e4-b18a-fe7344fb1ea4",
     *       "productId": "71e00fd4-3a45-11e4-b18a-fe7344fb1ea4",
     *       "areaId": "0b412a0e-397a-11e4-b18a-fe7344fb1ea4",
     *       "name": "existingCardHolder",
     *       "value": "1",
     *       "label": null,
     *       "editable": null,
     *       "visibility": null,
     *       "status": "1"
     *   },
     *   {
     *       "id": "e8227346-3a61-11e4-b18a-fe7344fb1ea4",
     *       "productId": "72c28c74-3a45-11e4-b18a-fe7344fb1ea4",
     *       "areaId": "0b412a0e-397a-11e4-b18a-fe7344fb1ea4",
     *       "name": "featured",
     *       "value": "0",
     *       "label": null,
     *       "editable": null,
     *       "visibility": null,
     *       "status": "1"
     *   }
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
		$productsOptions = new ProductsOptionsCollection($this->di);
		return $this->respond($productsOptions);
	}
	
	/**
	 * @api {get} /products_options/:id GET /products_options/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/products_options/e8227346-3a61-11e4-b18a-fe7344fb1ea4/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Products Options
	 * @apiName        GetOne
	 * @apiGroup       Products Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Products Options unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Products Options unique ID.
	 *
 	 * @apiSuccess     {String} id                       ID of the Products Option.
	 * @apiSuccess     {String} productId                Product ID of the Products Option.
	 * @apiSuccess     {String} areaID                   Area ID of the Products Option.
	 * @apiSuccess     {String} name                     Name of the Products Option.
	 * @apiSuccess     {String} value                    Value of the Products Option.
	 * @apiSuccess     {String} label                    Label of the Products Option.
	 * @apiSuccess     {String} editable                 Editable Flag of the Products Option. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Products Option.  
	 * @apiSuccess     {Number} status                   Status Flag of the Products Option. 
	 * @apiSuccess     {Number} active                   Active Flag of the Products Option. 
	 * @apiSuccess     {Date}   created                  Creation date of the Products Option. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Products Option. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Products Option. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Products Option. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
     *     {
     *       "id": "e8227346-3a61-11e4-b18a-fe7344fb1ea4",
     *       "productId": "72c28c74-3a45-11e4-b18a-fe7344fb1ea4",
     *       "areaId": "0b412a0e-397a-11e4-b18a-fe7344fb1ea4",
     *       "name": "featured",
     *       "value": "0",
     *       "label": null,
     *       "editable": null,
     *       "visibility": null,
     *       "status": "1",
	 *       "created": "2014-07-11 09:13:27",
     *       "modified": "2014-07-11 09:52:08",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "c6bcb740-1dcc-11e4-b32d-eff91066cccf"              
     *     }
	 *
	 * @apiError ProductsOptionNotFound The id of the Products Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ProductsOptionNotFound"
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
			$productsOptions = new ProductsOptionsCollection($this->di);
			$results = $this->respond($productsOptions, $id);
		}else{
			$results = ProductsOptionsCollection::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Products option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * @api {post} /products_options POST /products_options
     * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/products_options/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "productId=73a4f032-3a45-11e4-b18a-fe7344fb1ea4&
	 *          areaId=0b412a0e-397a-11e4-b18a-fe7344fb1ea4&
	 *          name=maxAge&
	 *          value=70&
	 *          status=1&
	 *          editable=1&
	 *          visibility=1"
	 * 
	 * @apiDescription  Create a new Products Options
	 * @apiName         Post
	 * @apiGroup        Products Options
	 *
	 * @apiHeader       {String} X-COMPARE-REST-API-KEY   Products Options unique access-key.
	 *
	 * @apiParam        {String} language                 Mandatory Language.
	 * @apiParam        {String} countryCode              Mandatory Country code.
	 * @apiParam        {String} productId                Mandatory Product ID of Products Options.
	 * @apiParam        {String} areaId                   Mandatory Area ID of Products Options.
	 * @apiParam        {String} name                     Mandatory Name of the Products Options.
	 * @apiParam        {String} value                    Mandatory Value of the Products Options.
	 * @apiParam        {String} [label]                  Optional Label of the Products Options.
	 * @apiParam        {String} [editable=0]             Optional Editable Flag of the Products Options.
	 * @apiParam        {String} [visibility=0]           Optional Visibility Value of the Products Options.
	 * @apiParam        {String} [status=0]               Optional Status of the Products Options.
	 * @apiParam        {String} [createdBy]              Optional ID of the User who created the Products Options.
	 * @apiParam        {String} [modifiedBy]             Optional ID of the User who modified the Products Options.
	 *	
	 * @apiSuccess      {String} id                       The new ProductsOptions-ID.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "3aa61eec-3c06-11e4-9a7a-90a27a7c008a"
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
			$productsOptions = new ProductsOptions();
			$data['id'] = $productsOptions->id;
			$data['productId'] = isset($data['productId']) ? $data['productId'] : '';
			$data['areaId'] = isset($data['areaId']) ? $data['areaId'] : '';
			$data['name'] = isset($data['name']) ? $data['name'] : '';
			$data['value'] = isset($data['value']) ? $data['value'] : '';
			$data['label'] = isset($data['label']) ? $data['label'] : '';
			$data['editable'] = isset($data['editable']) ? $data['editable'] : 0;
			$data['visibility'] = isset($data['visibility']) ? $data['visibility'] : 0;
			$data['status'] = isset($data['status']) ? $data['status'] : 0;
			if (isset($data['status'])) {
				$data['active'] = ($data['status'] != ProductsOptions::ACTIVE) ? 0 : 1 ;
				$data['editable'] = ($data['status'] != ProductsOptions::ACTIVE) ? 0 : $data['editable'];
				$data['visibility'] = ($data['status'] != ProductsOptions::ACTIVE) ? 0 : $data['visibility'];
			}
			$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
			$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';
			
			$products = Products::findFirstById($data['productId']);
			if ($products) {
				$channels = Channels::findFirstById($products->channelId);
				if ($channels) {
					$params[$data['name']] = $data['value'];
					$valid = $productsOptions->validateProperty($params, $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->$channels->alias);
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
				}
			}
			
			if ($productsOptions->save($data)){
				$results['id'] = $productsOptions->id;
			} else {
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $productsOptions->getMessages(),
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
	 * @api {delete} /products_options/:id DELETE /products_options/:id
	 * @apiExample Example usage:
	 * curl -i -X DELETE "http://apibeta.compargo.com/v1/products_options/74685aea-3a45-11e4-b18a-fe7344fb1ea4
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Delete a Products Option
	 * @apiName        Delete
	 * @apiGroup       Products Options
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Products Options unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Products Option Unique ID.
	 *
	 * @apiSuccess {String} id                       The ID of Products Option.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "74685aea-3a45-11e4-b18a-fe7344fb1ea4"
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
	 * @apiError ProductsOptionNotFound The id of the Products Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ProductsOptionNotFound"
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
		$productsOptions = ProductsOptions::findFirstById($id);
		if (!$productsOptions){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Products option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		} else {
			if ($productsOptions->delete()){
				$results['id'] = $productsOptions->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $productsOptions->getMessages(),
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
		}
		return $results;
	}
 	
	/**
	 * @api {put} /products_options/:id PUT /products_options/:id
	 * @apiExample Example usage:
	 * curl -i -X PUT "http://apibeta.compargo.com/v1/products_options/e8227346-3a61-11e4-b18a-fe7344fb1ea4/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "areaId=0b412a0e-397a-11e4-b18a-fe7344fb1ea4&
	 *          value=1&
	 *          status=0"
	 *      
	 * @apiDescription Update a Products Option
	 * @apiName  Put
	 * @apiGroup Products Options
	 *
	 * @apiHeader {String} X-COMPARE-REST-API-KEY   Products Options unique access-key.
	 *
	 * @apiParam  {String} language                 Mandatory Language.
	 * @apiParam  {String} countryCode              Mandatory Country Code.
	 * @apiParam  {String} id                       Mandatory Products Option Unique ID.
	 * @apiParam  {String} productId                Mandatory Product ID of the Products Option.
	 * @apiParam  {String} areaId                   Mandatory Area ID of the Products Option.
	 * @apiParam  {String} name                     Mandatory Name of the Products Option.
	 * @apiParam  {String} value                    Mandatory Value of the Products Option.
	 * @apiParam  {String} [label]                  Optional Label of the Products Option.
	 * @apiParam  {String} [editable]               Optional Editable Flag of the Products Option.
	 * @apiParam  {String} [visibility]             Optional Visibility Flag of the Products Option.
	 * @apiParam  {String} [status]                 Optional Status of the Products Option.
	 * @apiParam  {String} [createdBy]              Optional ID of the User who created the Products Option.
	 * @apiParam  {String} [modifiedBy]             Optional ID of the User who modified the Products Option.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "e8227346-3a61-11e4-b18a-fe7344fb1ea4"
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
	 * @apiError ProductsOptionNotFound The id of the Products Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ProductsOptionNotFound"
	 *     }
	 */
	public function put($id){
		$results = array();
		$request = $this->di->get('request');
		$data = $request->getPut();
		if (!empty($data)){
			$productsOptions = ProductsOptions::findFirstById($id);
			if (!$productsOptions){
				throw new HTTPException(
					"Not found",
					404,
					array(
						'dev' => 'Products option does not exist',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			} else {
				$data['productId'] = isset($data['productId']) ? $data['productId'] : $productsOptions->productId;
				$data['areaId'] = isset($data['areaId']) ? $data['areaId'] : $productsOptions->areaId;
				$data['name'] = isset($data['name']) ? $data['name'] : $productsOptions->name;
				$data['value'] = isset($data['value']) ? $data['value'] : $productsOptions->value;
				$data['label'] = isset($data['label']) ? $data['label'] : $productsOptions->label;
				$data['status'] = isset($data['status']) ? $data['status'] : $productsOptions->status;
				if (isset($data['status'])) {
					$data['active'] = ($data['status'] != ProductsOptions::ACTIVE) ? 0 : 1 ;
					$data['editable'] = ($data['status'] != ProductsOptions::ACTIVE) ? 0 : $productsOptions->editable;
					$data['visibility'] = ($data['status'] != ProductsOptions::ACTIVE) ? 0 : $productsOptions->visibility;
				}
				$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : $productsOptions->createdBy;
				$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : $productsOptions->modifiedBy;
				
				$products = Products::findFirstById($data['productId']);
				if ($products) {
					$channels = Channels::findFirstById($products->channelId);
					if ($channels) {
						$params[$data['name']] = $data['value'];
						$valid = $productsOptions->validateProperty($params, $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->$channels->alias);
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
					}
				}
				if ($productsOptions->save($data)){
					$results['id'] = $productsOptions->id;
				}else{
					throw new HTTPException(
						"Request unable to be followed due to semantic errors",
						422,
						array(
								'dev' => $productsOptions->getMessages(),
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
	 * @api {post} /products_options/search POST /products_options/search
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i -X POST "http://apibeta.compargo.com/v1/products_options/?countryCode=ph&language=en"
	 *      -d "query={"status":"1"}&
	 *          fields=id,productId,areaId,name,value,label,editable,visibility,status&
	 *          sort=-id,name&
	 *          limit=20"
	 *
	 * @apiDescription Read data of all Products Options
	 * @apiName        Search
	 * @apiGroup       Products Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Products Options unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of products options.
	 * 
	 * @apiSuccess     {String} id                       ID of the Products Options. 
	 * @apiSuccess     {String} productId                Product ID of the Products Options.
	 * @apiSuccess     {String} areaId                   Area ID of the Products Options. 
	 * @apiSuccess     {String} name                     Name of the Products Options. 
	 * @apiSuccess     {String} value                    Value of the Products Options. 
	 * @apiSuccess     {String} label                    Label of the Products Options.
	 * @apiSuccess     {String} editable                 Editable Flag of the Products Options. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Products Options.  
	 * @apiSuccess     {Number} status                   Status Flag of the Products Options. 
	 * @apiSuccess     {Number} active                   Active Flag of the Products Options. 
	 * @apiSuccess     {Date}   created                  Creation date of the Products Options. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Products Options. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Products Options. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Products Options. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
     *       "id": "e36429f8-3a61-11e4-b18a-fe7344fb1ea4",
     *       "productId": "6de2478a-3a45-11e4-b18a-fe7344fb1ea4",
     *       "areaId": "0b412a0e-397a-11e4-b18a-fe7344fb1ea4",
     *       "name": "minimumAgeSupplementary",
     *       "value": "13",
     *       "label": null,
     *       "editable": null,
     *       "visibility": null,
     *       "status": "1"
     *   },
     *   {
     *       "id": "e7ddeeba-3a61-11e4-b18a-fe7344fb1ea4",
     *       "productId": "71e00fd4-3a45-11e4-b18a-fe7344fb1ea4",
     *       "areaId": "0b412a0e-397a-11e4-b18a-fe7344fb1ea4",
     *       "name": "existingCardHolder",
     *       "value": "1",
     *       "label": null,
     *       "editable": null,
     *       "visibility": null,
     *       "status": "1"
     *   },
     *   {
     *       "id": "e8227346-3a61-11e4-b18a-fe7344fb1ea4",
     *       "productId": "72c28c74-3a45-11e4-b18a-fe7344fb1ea4",
     *       "areaId": "0b412a0e-397a-11e4-b18a-fe7344fb1ea4",
     *       "name": "featured",
     *       "value": "0",
     *       "label": null,
     *       "editable": null,
     *       "visibility": null,
     *       "status": "1"
     *   }
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
		$productsOptions = new ProductsOptionsCollection($this->di);
		return $this->respond($productsOptions);
	}
	
	/**
	 * @api {post} /products_options/search/:id POST /products_options/search/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i -X POST "http://apibeta.compargo.com/v1/products_options/e8227346-3a61-11e4-b18a-fe7344fb1ea4/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Products Options
	 * @apiName        SearchOne
	 * @apiGroup       Products Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Products Options unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Products Options unique ID.
	 *
 	 * @apiSuccess     {String} id                       ID of the Products Option.
	 * @apiSuccess     {String} productId                Product ID of the Products Option.
	 * @apiSuccess     {String} areaID                   Area ID of the Products Option.
	 * @apiSuccess     {String} name                     Name of the Products Option.
	 * @apiSuccess     {String} value                    Value of the Products Option.
	 * @apiSuccess     {String} label                    Label of the Products Option.
	 * @apiSuccess     {String} editable                 Editable Flag of the Products Option. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Products Option.  
	 * @apiSuccess     {Number} status                   Status Flag of the Products Option. 
	 * @apiSuccess     {Number} active                   Active Flag of the Products Option. 
	 * @apiSuccess     {Date}   created                  Creation date of the Products Option. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Products Option. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Products Option. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Products Option. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
     *     {
     *       "id": "e8227346-3a61-11e4-b18a-fe7344fb1ea4",
     *       "productId": "72c28c74-3a45-11e4-b18a-fe7344fb1ea4",
     *       "areaId": "0b412a0e-397a-11e4-b18a-fe7344fb1ea4",
     *       "name": "featured",
     *       "value": "0",
     *       "label": null,
     *       "editable": null,
     *       "visibility": null,
     *       "status": "1",
	 *       "created": "2014-07-11 09:13:27",
     *       "modified": "2014-07-11 09:52:08",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "c6bcb740-1dcc-11e4-b32d-eff91066cccf"              
     *     }
	 *
	 * @apiError ProductsOptionNotFound The id of the Products Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ProductsOptionNotFound"
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
			$productsOptions = new ProductsOptionsCollection($this->di);
			$results = $this->respond($productsOptions, $id);
		}else{
			$results = ProductsOptionsCollection::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Products option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
}