<?php
namespace App\Modules\Backend\Controllers;

use App\Modules\Backend\Models\Brands,
	App\Modules\Frontend\Models\Brands as BrandsCollection,
	App\Common\Lib\Application\Libraries\ImageUpload,
    App\Common\Lib\Application\Controllers\RESTController,
	App\Common\Lib\Application\Exceptions\HTTPException;


class BrandsController extends RESTController{

	/**
	 * Sets which fields may be searched against, and which fields are allowed to be returned in
	 * partial responses. 
	 * @var array
	 */
	protected $allowedFields = array(
		'search' => array(
			'id',
			'companyId',
			'name',	
			'alias',
			'logo',
			'link',
			'alias',
			'description',
			'language',
			'revenueValue',
			'status',
			'active',
			'created',
			'modified',
			'createdBy',
			'modifiedBy'
		),
		'partials' => array(
			'id',
			'companyId',
			'name',	
			'alias',
			'logo',
			'link',
			'alias',
			'description',
			'language',
			'revenueValue',
			'status',
			'active',
			'created',
			'modified',
			'createdBy',
			'modifiedBy'
		),
		'sort' => array(
			'id',
			'companyId',
			'name',
			'description',
			'language',
			'status',
			'active',
			'created',
			'modified',
			'createdBy',
			'modifiedBy'
		)	
	);
	
	protected $schemaDir;

	/**
	 * Sets which objects may be searched against, and which objects are allowed to be returned in
	 * partial responses.
	 * @var array
	 */
	protected $allowedObjects = array();
	
	/**
	 * Brand constructor
	 */
	public function __construct(){
		parent::__construct(false);
		$this->parseRequest($this->allowedFields, $this->allowedObjects);
		$this->schemaDir = __DIR__ . $this->getDI()->getConfig()->application->jsonSchemaDir;
	}
	
	/**
	 * @api {get} /brands GET /brands
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/brands/?countryCode=ph&language=en&query={"status":"1"}&fields=id,companyId,name,alias,logo,link,description,language,revenueValue,created,modified,createdBy,modifiedBy&sort=-id,companyId,name&limit=10"
	 *
	 * @apiDescription Read data of all Brands
	 * @apiName        Get
	 * @apiGroup       Brands
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Brand unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of brands.
	 * 
	 * @apiSuccess     {String} id                       ID of the Brand. 
	 * @apiSuccess     {String} companyId                Company ID of the Brand.
	 * @apiSuccess     {String} name                     Name of the Brand.
	 * @apiSuccess     {String} alias                    Alias of the Brand.
	 * @apiSuccess     {String} logo                     Logo of the Brand.
	 * @apiSuccess     {String} link                     Link of the Brand.
	 * @apiSuccess     {String} description              Description of the Brand.
	 * @apiSuccess     {String} language                 Language of the Brand.
	 * @apiSuccess     {String} revenueValue             Language of the Brand.
	 * @apiSuccess     {Number} status                   Status Flag of the Brand.
	 * @apiSuccess     {Number} active                   Active Flag of the Brand.
	 * @apiSuccess     {Date}   created                  Creation date of the Brand.
	 * @apiSuccess     {Date}   modified                 Modification date of the Brand.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Brand.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Brand.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "1ded6cc0-21de-11e4-b700-0b28aad944c8",
     *       "companyId": "10f0c896-2134-11e4-bb06-0a68ec684316",
     *       "name": "BPI",
     *       "alias": "bpi",
     *       "logo": "ph/companies/bpi_1.jpg",
     *       "link": "bpicards.com",
     *       "description": "BPI",
     *       "language": "en",
     *       "revenueValue": "5.00",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-12 07:04:19",
     *       "modified": "2014-08-12 14:10:43",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     },
     *     {
     *      "id": "bc75db6e-2dde-11e4-988c-7d9574853fac",
     *      "companyId": "ce0f98c6-2ddc-11e4-988c-7d9574853fac",
     *      "name": "Bank of Commerce",
     *      "alias": "bank-of-commerce",
     *      "logo": null,
     *      "link": null,
     *      "description": null,
     *      "language": "en",
     *      "revenueValue": null,
     *      "status": "1",
     *      "active": "1",
     *      "created": "2014-08-27 13:38:59",
     *      "modified": "0000-00-00 00:00:00",
     *      "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *      "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
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
		$brands = new BrandsCollection($this->di);
		return $this->respond($brands);
	}
	
	/**
	 * @api {get} /brands/:id GET /brands/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/brands/07f44e24-1d43-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Brand
	 * @apiName        GetOne
	 * @apiGroup       Brands
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Brands unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Brands unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Brand.
	 * @apiSuccess     {String} name                     Name of the Brand.
	 * @apiSuccess     {String} alias                    Alias of the Brand.
	 * @apiSuccess     {String} description              Description of the Brand.
	 * @apiSuccess     {Number} status                   Status of the Brand.
     * @apiSuccess     {Number} active                   Flag of the Brand.
	 * @apiSuccess     {Date}   created                  Creation date of the Brand.
	 * @apiSuccess     {Date}   modified                 Modification date of the Brand.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Brand.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Brand.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *      "id": "bc75db6e-2dde-11e4-988c-7d9574853fac",
     *      "companyId": "ce0f98c6-2ddc-11e4-988c-7d9574853fac",
     *      "name": "Bank of Commerce",
     *      "alias": "bank-of-commerce",
     *      "logo": null,
     *      "link": null,
     *      "description": null,
     *      "language": "en",
     *      "revenueValue": null,
     *      "status": "1",
     *      "active": "1",
     *      "created": "2014-08-27 13:38:59",
     *      "modified": "0000-00-00 00:00:00",
     *      "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *      "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     }
	 *
	 * @apiError BrandNotFound The id of the Brand was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "BrandNotFound"
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
			$brand = new BrandsCollection();
			$results = $this->respond($brand, $id);
		}else{
			$results = BrandsCollection::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Brand does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * @api {post} /brands POST /brands
     * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/brands/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "companyId=4c8367bc-319a-11e4-988c-7d9574853fac&name=BDO&language=en&status=1"
	 * 
	 * @apiDescription  Create a new Brand
	 * @apiName         Post
	 * @apiGroup        Brands
	 *
	 * @apiHeader       {String} X-COMPARE-REST-API-KEY   Brand unique access-key.
	 *
	 * @apiParam        {String} language                 Mandatory Language.
	 * @apiParam        {String} countryCode              Mandatory Country code.
	 * @apiParam        {String} name                     Mandatory Name of the Brand.
	 * @apiParam        {String} alias                    Mandatory Alias of the Brand.
	 * @apiParam        {String} [logo]                   Optional Logo of the Brand.
	 * @apiParam        {String} [link]                   Optional Link of the Brand.
	 * @apiParam        {String} [description]            Optional Description of the Brand.
	 * @apiParam        {String} [revenueValue]           Optional Revenue Value of the Brand.
	 * @apiParam        {String} [alias]                  Optional Alias of the Brand.
	 * @apiParam        {String} [status=0]               Optional Status of the Brand.
     * @apiParam        {String} [createdBy]              Optional ID of the User who created the Vertical.
	 * @apiParam        {String} [modifiedBy]             Optional ID of the User who modified the Vertical.
     *
	 * @apiSuccess      {String} id                       The new Brand-ID.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "dec7a1fe-370a-11e4-b18a-fe7344fb1ea4"
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
		$results = $params = array();
		$request = $this->di->get('request');
		$data = $request->getPost();

		if (!empty($data)){
			$brand = new Brands();
			$data['id'] = $brand->id;
			$data['companyId'] = isset($data['companyId']) ? $data['companyId'] : '';
			$data['name'] = isset($data['name']) ? $data['name'] : '';
			$data['alias'] = isset($data['alias']) ? $data['alias'] : '';
			$data['logo'] = isset($data['logo']) ? $data['logo'] : '';
			$data['link'] = isset($data['link']) ? $data['link'] : '';
			$data['description'] = isset($data['description']) ? $data['description'] : '';
			$data['language'] = isset($data['language']) ? $data['language'] : '';
			$data['revenueValue'] = isset($data['revenueValue']) ? $data['revenueValue'] : '0.00';
			$data['status'] = isset($data['status']) ? $data['status'] : 0;
			
			// iterate each field on the json schemaj
			// and fill parameters to feed on validator later
			// required/mandatory fields w/o values will trigger a validation error
			$schemaFile = $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->brands;
			$output = readJsonFromFile($schemaFile, $this);
			if (!empty($output)) {
				$properties = $output['properties'];
				foreach ($properties as $key => $value) {
					if ( $key == 'options' ) continue;
					$params[$key] = !(empty($data[$key]))? $data[$key] : '';
				}
			}
			
			// $params['name'] = $data['name'];
			// $params['logo'] = $data['logo'];
			// $params['link'] = $data['link'];
			// $params['description'] = $data['description'];
			// $params['revenueValue'] = $data['revenueValue'];

			$valid = $brand->validateProperty($params, $schemaFile);
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

			if (isset($data['status'])) {
				$data['active'] = ($data['status'] != Brands::ACTIVE) ? 0 : 1 ;
			}
			$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
			$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';
			
			if ($brand->save($data)) {
				$results['id'] = $brand->id;
			} else {
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $brand->getMessages(),
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
	 * @api {delete} /brands/:id DELETE /brands/:id
	 * @apiExample Example usage:
	 * curl -i -X DELETE "http://apibeta.compargo.com/v1/brands/dec7a1fe-370a-11e4-b18a-fe7344fb1ea4/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Delete a Brand
	 * @apiName        Delete
	 * @apiGroup       Brands
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Brand unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Brand Unique ID.
	 *
	 * @apiSuccess {String} id                       The ID of Brand.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "574a5eb2-1d59-11e4-b32d-eff91066cccf"
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
	 * @apiError BrandNotFound The id of the Brand was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "BrandNotFound"
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
		$results = array();
		$brand = Brands::findFirstById($id);
		if (!$brand){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Brand does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		} else {
			if ($brand->delete()){
				$results['id'] = $brand->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $brand->getMessages(),
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
		}
		return $results;
	}
 	
	/**
	 * @api {put} /brands/:id PUT /brands/:id
	 * @apiExample Example usage:
	 * curl -i -X PUT "http://apibeta.compargo.com/v1/brands/1c28fefa-319b-11e4-988c-7d9574853fac/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "name=PNB&link=http://www.pnb.com.ph&logo=ph/brands/10_pnb.gif"
	 *      
	 * @apiDescription Update a Brand
	 * @apiName  Put
	 * @apiGroup Brands
	 *
	 * @apiHeader {String} X-COMPARE-REST-API-KEY   Vertical unique access-key.
	 *
	 * @apiParam  {String} language                 Mandatory Language.
	 * @apiParam  {String} countryCode              Mandatory Country Code.
	 * @apiParam  {String} id                       Mandatory Brand Unique ID.
	 * @apiParam  {String} companyId                Mandatory Company ID of the Brand.
	 * @apiParam  {String} name                     Mandatory Name of the Brand.
	 * @apiParam  {String} [alias]                  Optional Alias of the Brand.
	 * @apiParam  {String} [logo]                   Optional Logo of the Brand.
	 * @apiParam  {String} [link]                   Optional Link of the Brand.
	 * @apiParam  {String} [description]            Optional Description of the Brand.
	 * @apiParam  {String} [revenueValue]           Optional Revenue Value of the Brand.
	 * @apiParam  {String} [status]                 Optional Status of the Brand.
	 * @apiParam  {String} [createdBy]              Optional ID of the User who created the Vertical.
	 * @apiParam  {String} [modifiedBy]             Optional ID of the User who modified the Vertical.
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
	 * @apiError BrandNotFound The id of the Brand was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "BrandNotFound"
	 *     }
	 */
	public function put($id){
		$results = $params = array();
		$request = $this->di->get('request');
		$data = $request->getPut();
		
		if (!empty($data)) {
			$brand = Brands::findFirstById($id);
			if (!$brand){
				throw new HTTPException(
					"Not found",
					404,
					array(
						'dev' => 'Brand does not exist',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			} else {
				$data['companyId'] = isset($data['companyId']) ? $data['companyId'] : $brand->companyId;
				$data['name'] = isset($data['name']) ? $data['name'] : $brand->name;
				$data['alias'] = isset($data['alias']) ? $data['alias'] : $brand->alias;
				$data['logo'] = isset($data['logo']) ? $data['logo'] : $brand->logo;
				$data['link'] = isset($data['link']) ? $data['link'] : $brand->link;
				$data['description'] = isset($data['description']) ? $data['description'] : $brand->description;
				$data['language'] = isset($data['language']) ? $data['language'] : $brand->language;
				$data['revenueValue'] = isset($data['revenueValue']) ? $data['revenueValue'] : $brand->revenueValue;
				if (isset($data['status'])) {
					$data['active'] = ($data['status'] != Brands::ACTIVE) ? 0 : 1 ;
				}
				$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : $brand->createdBy;
				$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : $brand->modifiedBy;
				
				$params['companyId'] = $data['companyId'];
				$params['name'] = $data['name'];
				$params['logo'] = $data['logo'];
				$params['link'] = $data['link'];
				$params['alias'] = $data['alias'];
				$params['description'] = $data['description'];
				$params['revenueValue'] = $data['revenueValue'];
				
				$valid = $brand->validateProperty($params, $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->brands);
				if(!empty($valid)) {
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
				
				if ($brand->update($data)){
					$results['id'] = $brand->id;
				} else {
					throw new HTTPException(
						"Request unable to be followed due to semantic errors",
						422,
						array(
							'dev' => $brand->getMessages(),
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
	 * @api {post} /brands POST /brands/search
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/brands/search/?countryCode=ph&language=en"
	 *      -d "query={"status":"1"}&
	 *          fields=id,companyId,name,alias,logo,link,description,language,revenueValue,created,modified,createdBy,modifiedBy&
	 *          sort=-id,-companyId,name&
	 *          limit=10"
	 *
	 * @apiDescription Read data of all Brands
	 * @apiName        Search
	 * @apiGroup       Brands
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Brand unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of brands.
	 * 
	 * @apiSuccess     {String} id                       ID of the Brand. 
	 * @apiSuccess     {String} companyId                Company ID of the Brand.
	 * @apiSuccess     {String} name                     Name of the Brand.
	 * @apiSuccess     {String} alias                    Alias of the Brand.
	 * @apiSuccess     {String} logo                     Logo of the Brand.
	 * @apiSuccess     {String} link                     Link of the Brand.
	 * @apiSuccess     {String} description              Description of the Brand.
	 * @apiSuccess     {String} language                 Language of the Brand.
	 * @apiSuccess     {String} revenueValue             Language of the Brand.
	 * @apiSuccess     {Number} status                   Status Flag of the Brand.
	 * @apiSuccess     {Number} active                   Active Flag of the Brand.
	 * @apiSuccess     {Date}   created                  Creation date of the Brand.
	 * @apiSuccess     {Date}   modified                 Modification date of the Brand.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Brand.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Brand.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "1ded6cc0-21de-11e4-b700-0b28aad944c8",
     *       "companyId": "10f0c896-2134-11e4-bb06-0a68ec684316",
     *       "name": "BPI",
     *       "alias": "bpi",
     *       "logo": "ph/companies/bpi_1.jpg",
     *       "link": "bpicards.com",
     *       "description": "BPI",
     *       "language": "en",
     *       "revenueValue": "5.00",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-12 07:04:19",
     *       "modified": "2014-08-12 14:10:43",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     },
     *     {
     *      "id": "bc75db6e-2dde-11e4-988c-7d9574853fac",
     *      "companyId": "ce0f98c6-2ddc-11e4-988c-7d9574853fac",
     *      "name": "Bank of Commerce",
     *      "alias": "bank-of-commerce",
     *      "logo": null,
     *      "link": null,
     *      "description": null,
     *      "language": "en",
     *      "revenueValue": null,
     *      "status": "1",
     *      "active": "1",
     *      "created": "2014-08-27 13:38:59",
     *      "modified": "0000-00-00 00:00:00",
     *      "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *      "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
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
		$brand = new BrandsCollection($this->di);
		return $this->respond($brand);
	}
	
	/**
	 * @api {post} /brands/search/:id POST /brands/search/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/brands/search/07f44e24-1d43-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Brand
	 * @apiName        SearchOne
	 * @apiGroup       Brands
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Brands unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Brands unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Brand.
	 * @apiSuccess     {String} name                     Name of the Brand.
	 * @apiSuccess     {String} alias                    Alias of the Brand.
	 * @apiSuccess     {String} description              Description of the Brand.
	 * @apiSuccess     {Number} status                   Status of the Brand.
     * @apiSuccess     {Number} active                   Flag of the Brand.
	 * @apiSuccess     {Date}   created                  Creation date of the Brand.
	 * @apiSuccess     {Date}   modified                 Modification date of the Brand.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Brand.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Brand.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *      "id": "bc75db6e-2dde-11e4-988c-7d9574853fac",
     *      "companyId": "ce0f98c6-2ddc-11e4-988c-7d9574853fac",
     *      "name": "Bank of Commerce",
     *      "alias": "bank-of-commerce",
     *      "logo": null,
     *      "link": null,
     *      "description": null,
     *      "language": "en",
     *      "revenueValue": null,
     *      "status": "1",
     *      "active": "1",
     *      "created": "2014-08-27 13:38:59",
     *      "modified": "0000-00-00 00:00:00",
     *      "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *      "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     }
	 *
	 * @apiError BrandNotFound The id of the Brand was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "BrandNotFound"
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
			$brand = new BrandsCollection($this->di);
			$results = $this->respond($brand, $id);
		}else{
			$results = BrandsCollection::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Brand does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * @api {put} /brands/upload/:id PUT /brands/upload/:id
	 * @apiExample Example usage:
	 * curl --upload-file /home/moneymax/brands/bpi-family.png "http://apibeta.compargo.com/v1/brands/upload/0d6b45a6-3eea-11e4-9a7a-90a27a7c008a/?language=en&countryCode=ph
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *
	 * @apiDescription Upload a Brand Image
	 * @apiName        Delete
	 * @apiGroup       Brands
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Brands unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Company Unique ID.
	 * @apiParam   {String} file                     Mandatory File.
	 *
	 * @apiSuccess {String} id                       The ID of Brand.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "0d6b45a6-3eea-11e4-9a7a-90a27a7c008a"
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
	 * @apiError BrandNotFound The id of the Brand was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "BrandNotFound"
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
	public function upload($id){
		$parameters = $results = array();
		$requestBody = file_get_contents("php://input");
		$request = $this->di->get('request');
		$language = $request->get()['language'];
	
		if (!empty($requestBody)) {
			$brand = Brands::findFirstById($id);
			if ($brand) {
				$width = isset($request->get()['width']) ? $request->get()['width'] : '';
				$height = isset($request->get()['height']) ? $request->get()['height'] : '';
				$quality = isset($request->get()['quality']) ? $request->get()['quality'] : 85;
	
				$parameters = array(
						'prefix'        => $id . '_',
						'basename'      => $brand->name,
						'uploadpath'    => $language . '/brands/',
						'max_width'     => $width,
						'max_height'    => $height,
						'quality'       => $quality
				);
	
				$image = new ImageUpload();
				if ($filename = $image->save($requestBody, $parameters)) {
					$brand->logo = $filename;
					if ($brand->save()) {
						$brandCollection = BrandsCollection::findFirst(array('condition' => array('id' => $id)));
						$brandCollection->logo = $filename;
						if ($brandCollection->save()) {
							$results[] = $brandCollection;
						}
					}
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
}