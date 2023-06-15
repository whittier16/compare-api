<?php
namespace App\Modules\Backend\Controllers;

use App\Modules\Backend\Models\Companies as Companies,
	App\Modules\Frontend\Models\Companies as CompaniesCollection,
    App\Common\Lib\Application\Controllers\RESTController,
    App\Common\Lib\Application\Exceptions\HTTPException,
    App\Common\Lib\Application\Libraries\ImageUpload;


class CompaniesController extends RESTController{

	/**
	 * Sets which fields may be searched against, and which fields are allowed to be returned in
	 * partial responses. 
	 * @var array
	 */
	protected $allowedFields = array(
		'search' => array(
			'id',
			'name',	
			'alias',
			'logo',
			'link',
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
			'name',	
			'alias',
			'logo',
			'link',
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
			'name',	
			'alias',
			'logo',
			'link',
			'description',
			'language',
			'revenueValue',
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
	 * Company constructor
	 */
	public function __construct(){
		parent::__construct(false);
		$this->parseRequest($this->allowedFields, $this->allowedObjects);
		$this->schemaDir = __DIR__ . $this->getDI()->getConfig()->application->jsonSchemaDir;
	}
	
	/**
	 * @api {get} /companies GET /companies
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/companies/?countryCode=ph&language=en&query={"status":"1"}&
	 *          fields=id,name,description,alias,logo,link,language,revenueValue,status,fax,phone&
	 *          sort=-id,name&
	 *          limit=10"
	 *
	 * @apiDescription Read data of all Companies
	 * @apiName        Get
	 * @apiGroup       Companies
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Companies unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of companies.
	 * 
	 * @apiSuccess     {String} id                       ID of the Company.
	 * @apiSuccess     {String} name                     Name of the Company.
	 * @apiSuccess     {String} description              Description of the Company.
	 * @apiSuccess     {String} alias                    Alias of the Company.
	 * @apiSuccess     {String} logo                     Logo of the Company.
	 * @apiSuccess     {String} link                     Link of the Company.
	 * @apiSuccess     {String} revenueValue             Language of the Company.
	 * @apiSuccess     {Number} status                   Status Flag of the Company.
	 * @apiSuccess     {Number} active                   Active Flag of the Company.
	 * @apiSuccess     {Date}   created                  Creation date of the Company.
	 * @apiSuccess     {Date}   modified                 Modification date of the Company.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Company.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Company.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "10f0c896-2134-11e4-bb06-0a68ec684316",
     *       "name": "BPI",
     *       "alias": "bpi",
     *       "logo": "ph/companies/1_bpi.jpg",
     *       "link": "bpicards.com",
     *       "description": "BPI",
     *       "language": "en",
     *       "revenueValue": "5.00",
     *       "status": "1",
     *       "fax": "1234567",
	 *       "phone": "1234567"
     *     },
     *     {
     *       "id": "dc7c34e2-1eae-11e4-b32d-eff91066cccf",
     *       "name": "BDO",
     *       "alias": "bdo",
     *       "description": "BDO",
     *       "logo": "ph/companies/bdo.jpg",
     *       "link": "bdo.com",
     *       "language": "en",
     *       "revenueValue": "5.00",
     *       "status": "1",
     *       "fax": "1234567",
	 *       "phone": "1234567"
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
		$company = new CompaniesCollection($this->di);
		return $this->respond($company);
	}
	
	/**
	 * @api {get} /companies/:id GET /companies/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -i "http://apibeta.compargo.com/v1/companies/4c8367bc-319a-11e4-988c-7d9574853fac/?countryCode=ph&language=en"
	 *
	 * @apiDescription Read data of a Companies
	 * @apiName        GetOne
	 * @apiGroup       Companies
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Companies unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Company unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Company.
	 * @apiSuccess     {String} name                     Name of the Company.
	 * @apiSuccess     {String} description              Description of the Company.
	 * @apiSuccess     {String} alias                    Alias of the Company.
	 * @apiSuccess     {String} logo                     Logo of the Company.
	 * @apiSuccess     {String} link                     Link of the Company.
	 * @apiSuccess     {String} revenueValue             Language of the Company.
	 * @apiSuccess     {Number} status                   Status Flag of the Company.
	 * @apiSuccess     {Number} active                   Active Flag of the Company.
	 * @apiSuccess     {Date}   created                  Creation date of the Company.
	 * @apiSuccess     {Date}   modified                 Modification date of the Company.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Company.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Company.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "10f0c896-2134-11e4-bb06-0a68ec684316",
	 *       "name": "BPI",
	 *       "alias": "bpi",
	 *       "logo": "ph/companies/1_bpi.jpg",
	 *       "link": "bpicards.com",
	 *       "description": "BPI",
	 *       "language": "en",
	 *       "revenueValue": "5.00",
	 *       "status": "1",
	 *       "created": "2014-08-11 10:47:03",
	 *       "modified": "2014-08-19 12:36:58",
	 *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
    *        "fax": "1234567",
	 *       "phone": "1234567"
	 *     }
	 *
	 * @apiError CompanyNotFound The id of the Company was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CompanyNotFound"
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
			$company = new CompaniesCollection($this->di);
			$results = $this->respond($company, $id);
		}else{
			$results = CompaniesCollection::find(array(
				array("id" => $id)
			));
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Company does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * @api {post} /companies POST /companies
	 * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/companies/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "verticalId=07f44e24-1d43-11e4-b32d-eff91066cccf&
	 *          name=HSBC&
	 *          alias=hsbc&
	 *          logo=ph/companies/hsbc.jpg&
	 *          link=hsbc.com.ph&
	 *          description=HSBC&
	 *          language=en&
	 *          revenueValue=5.00&
	 *          status=1"
	 *
	 * @apiDescription  Create a new Company
	 * @apiName         Post
	 * @apiGroup        Companies
	 *
	 * @apiHeader       {String} X-COMPARE-REST-API-KEY   Companies unique access-key.
	 *
	 * @apiParam        {String} language                 Mandatory Language.
	 * @apiParam        {String} countryCode              Mandatory Country code.
	 * @apiParam        {String} name                     Mandatory Name of the Company.
	 * 
	 * @apiParam        {String} [description]            Optional Description of the Company.
	 * @apiParam        {String} [alias]                  Optional Alias of the Company.
	 * @apiParam        {String} [logo]                   Optional Logo of the Company.
	 * @apiParam        {String} [link]                   Optional Link of the Company.
	 * @apiParam        {String} [revenueValue]           Optional Revenue Value of the Company.
	 * @apiParam        {String} [createdBy]              Optional ID of the User who created the Company.
	 * @apiParam        {String} [modifiedBy]             Optional ID of the User who modified the Company.
	 *
	 * @apiSuccess      {String} id                       The new Company-ID.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "33f42f48-37b6-11e4-b18a-fe7344fb1ea4"
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
	public function post() {
		$results = $params = array();
		$request = $this->di->get('request');
		$data = $request->getPost();
		if (!empty($data)) {
			$company = new Companies();
			$data['id'] = $company->id;
			$data['alias'] = isset($data['alias']) ? $data['alias'] : '';
			$data['logo'] = isset($data['logo']) ? $data['logo'] : '';
			$data['link'] = isset($data['link']) ? $data['link'] : '';
			$data['description'] = isset($data['description']) ? $data['description'] : '';
			$data['language'] = isset($data['language']) ? $data['language'] : '';
			$data['revenueValue'] = isset($data['revenueValue']) ? $data['revenueValue'] : '0.00';

			// iterate each field on the json schemaj
			// and fill parameters to feed on validator later
			// required/mandatory fields w/o values will trigger a validation error
			$schemaFile = $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->companies;
			$output = readJsonFromFile($schemaFile, $this);
			if (!empty($output)) {
				$properties = $output['properties'];
				foreach ($properties as $key => $value) {
					if ( $key == 'options' ) continue;
					$params[$key] = !(empty($data[$key]))? $data[$key] : '';
				}
			}
			// var_dump($params); die;
			
			// $params['name'] = isset($data['name']) ? $data['name'] : '';
			// $params['logo'] = $data['logo'];
			// $params['link'] = $data['link'];
			// $params['description'] = $data['description'];
			// $params['language'] = $data['language'];
			// $params['revenueValue'] = $data['revenueValue'];
			// $params['featured'] = $data['featured'];
			
			$valid = $company->validateProperty($params, $schemaFile);
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
			
			$data['status'] = isset($data['status']) ? $data['status'] : 0;
			if (isset($data['status'])) {
				$data['active'] = ($data['status'] != Companies::ACTIVE) ? 0 : 1 ;
			}
			$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
			$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';
		
			if ($company->create($data)){
				$results['id'] = $company->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors.",
					422,
					array(
						'dev' => $company->getMessages(),
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
	 * @api {delete} /companies/:id DELETE /companies/:id
	 * @apiExample Example usage:
	 * curl -i -X DELETE "http://apibeta.compargo.com/v1/companies/96b3d052-3716-11e4-b18a-fe7344fb1ea4	
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Delete a Company
	 * @apiName        Delete
	 * @apiGroup       Companies
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Companies unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Company Unique ID.
	 *
	 * @apiSuccess {String} id                       The ID of Company.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "96b3d052-3716-11e4-b18a-fe7344fb1ea4"
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
	 * @apiError CompanyNotFound The id of the Company was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CompanyNotFound"
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
		$company = Companies::findFirstById($id);
		if (!$company){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Company does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		} else {
			if ($company->delete()){
				$results['id'] = $company->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $company->getMessages(),
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
		}
		return $results;
	}
 	
	/**
	 * @api {put} /companies/:id PUT /companies/:id
	 * @apiExample Example usage:
	 * curl -i -X PUT "http://apibeta.compargo.com/v1/companies/96b3d052-3716-11e4-b18a-fe7344fb1ea4/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "name=PNB&link=http://www.pnb.com.ph&logo=ph/brands/10_pnb.gif"
	 *      
	 * @apiDescription Update a Company
	 * @apiName  Put
	 * @apiGroup Companies
	 *
	 * @apiHeader {String} X-COMPARE-REST-API-KEY   Companies unique access-key.
	 *
	 * @apiParam  {String} language                 Mandatory Language.
	 * @apiParam  {String} countryCode              Mandatory Country Code.
	 * @apiParam  {String} id                       Mandatory Company Unique ID.
	 * @apiParam  {String} name                     Mandatory Name of the Company.
	 * @apiParam  {String} [description]            Optional Description of the Company.
	 * @apiParam  {String} [alias]                  Optional Alias of the Company.
	 * @apiParam  {String} [logo]                   Optional Logo of the Company.
	 * @apiParam  {String} [link]                   Optional Link of the Company.
	 * @apiParam  {String} [revenueValue]           Optional Revenue Value of the Company.
	 * @apiParam  {String} [status]                 Optional Status of the Company.
	 * @apiParam  {String} [createdBy]              Optional ID of the User who created the Company.
	 * @apiParam  {String} [modifiedBy]             Optional ID of the User who modified the Company.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "4c8367bc-319a-11e4-988c-7d9574853fac"
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
	 * @apiError CompanyNotFound The id of the Company was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CompanyNotFound"
	 *     }
	 */
	public function put($id){
		$results = $params = array();
		$request = $this->di->get('request');
		$data = $request->getPut();
		if (!empty($data)) {
			$company = Companies::findFirstById($id);
			if (!$company){
				throw new HTTPException(
					"Not found",
					404,
					array(
						'dev' => 'Company does not exist',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			} else {
				$data['name'] = isset($data['name']) ? $data['name'] : $company->name;
				$data['alias'] = isset($data['alias']) ? $data['alias'] : '';
				$data['logo'] = isset($data['logo']) ? $data['logo'] : $company->logo;
				$data['link'] = isset($data['link']) ? $data['link'] : $company->link;
				$data['description'] = isset($data['description']) ? $data['description'] : $company->description;
				$data['language'] = isset($data['language']) ? $data['language'] : $company->language;
				$data['revenueValue'] = isset($data['revenueValue']) ? $data['revenueValue'] : $company->revenueValue;
				$data['status'] = isset($data['status']) ? $data['status'] : $company->status;
				if (isset($data['status'])) {
					$data['active'] = ($data['status'] != Companies::ACTIVE) ? 0 : 1 ;
				}
				$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : $company->createdBy;
				$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : $company->modifiedBy;
				
				$params['name'] = $data['name'];
				$params['logo'] = $data['logo'];
				$params['link'] = $data['link'];
				$params['description'] = $data['description'];
				$params['language'] = $data['language'];
				$params['revenueValue'] = $data['revenueValue'];

				$valid = $company->validateProperty($params, $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->companies);

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
				
				if ($company->save($data)){
					$results['id'] = $company->id;
				}else{
					throw new HTTPException(
						"Request unable to be followed due to semantic errors",
						422,
						array(
							'dev' => $company->getMessages(),
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
	 * @api {POST} /companies/search POST /companies/search
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/companies/?countryCode=ph&language=en"
	 *      -d "query={"status":"1"}&
	 *          fields=id,name,description,alias,logo,link,language,revenueValue,status,fax,phone&
	 *          sort=-id,name&
	 *          limit=10"
	 *
	 * @apiDescription Read data of all Companies
	 * @apiName        Search
	 * @apiGroup       Companies
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Companies unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of companies.
	 * 
	 * @apiSuccess     {String} id                       ID of the Company.
	 * @apiSuccess     {String} name                     Name of the Company.
	 * @apiSuccess     {String} description              Description of the Company.
	 * @apiSuccess     {String} alias                    Alias of the Company.
	 * @apiSuccess     {String} logo                     Logo of the Company.
	 * @apiSuccess     {String} link                     Link of the Company.
	 * @apiSuccess     {String} revenueValue             Language of the Company.
	 * @apiSuccess     {Number} status                   Status Flag of the Company.
	 * @apiSuccess     {Number} active                   Active Flag of the Company.
	 * @apiSuccess     {Date}   created                  Creation date of the Company.
	 * @apiSuccess     {Date}   modified                 Modification date of the Company.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Company.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Company.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "10f0c896-2134-11e4-bb06-0a68ec684316",
     *       "name": "BPI",
     *       "alias": "bpi",
     *       "logo": "ph/companies/1_bpi.jpg",
     *       "link": "bpicards.com",
     *       "description": "BPI",
     *       "language": "en",
     *       "revenueValue": "5.00",
     *       "status": "1",
    *        "fax": "1234567",
	 *       "phone": "1234567"
     *     },
     *     {
     *       "id": "dc7c34e2-1eae-11e4-b32d-eff91066cccf",
     *       "name": "BDO",
     *       "alias": "bdo",
     *       "description": "BDO",
     *       "logo": "ph/companies/bdo.jpg",
     *       "link": "bdo.com",
     *       "language": "en",
     *       "revenueValue": "5.00",
     *       "status": "1",
     *       "fax": "1234567",
	 *       "phone": "1234567"
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
		$company = new CompaniesCollection($this->di);
		return $this->respond($company);
	}
	
	/**
	 * @api {post} /companies/search/:id GET /companies/search/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -i "http://apibeta.compargo.com/v1/companies/search/4c8367bc-319a-11e4-988c-7d9574853fac/?countryCode=ph&language=en"
	 *
	 * @apiDescription Read data of a Companies
	 * @apiName        SearchOne
	 * @apiGroup       Companies
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Companies unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Company unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Company.
	 * @apiSuccess     {String} name                     Name of the Company.
	 * @apiSuccess     {String} description              Description of the Company.
	 * @apiSuccess     {String} alias                    Alias of the Company.
	 * @apiSuccess     {String} logo                     Logo of the Company.
	 * @apiSuccess     {String} link                     Link of the Company.
	 * @apiSuccess     {String} revenueValue             Language of the Company.
	 * @apiSuccess     {Number} status                   Status Flag of the Company.
	 * @apiSuccess     {Number} active                   Active Flag of the Company.
	 * @apiSuccess     {Date}   created                  Creation date of the Company.
	 * @apiSuccess     {Date}   modified                 Modification date of the Company.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Company.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Company.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "10f0c896-2134-11e4-bb06-0a68ec684316",
	 *       "name": "BPI",
	 *       "alias": "bpi",
	 *       "logo": "ph/companies/1_bpi.jpg",
	 *       "link": "bpicards.com",
	 *       "description": "BPI",
	 *       "language": "en",
	 *       "revenueValue": "5.00",
	 *       "status": "1",
	 *       "created": "2014-08-11 10:47:03",
	 *       "modified": "2014-08-19 12:36:58",
	 *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "fax": "1234567",
	 *       "phone": "1234567"
	 *     }
	 *
	 * @apiError CompanyNotFound The id of the Company was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CompanyNotFound"
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
			$company = new CompaniesCollection($this->di);
			$results = $this->respond($company, $id);
		}else{
			$results = CompaniesCollection::find(array(
				array("id" => $id)
			));
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Company does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * @api {put} /companies/upload/:id PUT /companies/upload/:id
	 * @apiExample Example usage:
	 * curl --upload-file /home/moneymax/companies/bpi.png "http://apibeta.compargo.com/v1/companies/upload/0c00ae86-3eea-11e4-9a7a-90a27a7c008a/?language=en&countryCode=ph
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *
	 * @apiDescription Upload a Company Image
	 * @apiName        Delete
	 * @apiGroup       Companies
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Companies unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Company Unique ID.
	 * @apiParam   {String} file                     Mandatory File.
	 *
	 * @apiSuccess {String} id                       The ID of Company.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "96b3d052-3716-11e4-b18a-fe7344fb1ea4"
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
	 * @apiError CompanyNotFound The id of the Company was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "CompanyNotFound"
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
			$company = Companies::findFirstById($id);
			if ($company) {
				$width = isset($request->get()['width']) ? $request->get()['width'] : '';
				$height = isset($request->get()['height']) ? $request->get()['height'] : '';
				$quality = isset($request->get()['quality']) ? $request->get()['quality'] : 85;
	
				$parameters = array(
						'prefix'        => $id . '_',
						'basename'      => $company->name,
						'uploadpath'    => $language . '/companies/',
						'max_width'     => $width,
						'max_height'    => $height,
						'quality'       => $quality
				);
	
				$image = new ImageUpload();
				if ($filename = $image->save($requestBody, $parameters)) {
					$company->logo = $filename;
					if ($company->save()) {
						$companyCollection = CompaniesCollection::findFirst(array('condition' => array('id' => $id)));
						$companyCollection->logo = $filename;
						if ($companyCollection->save()) {
							$results[] = $companyCollection;
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