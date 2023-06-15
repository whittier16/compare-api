<?php
namespace App\Modules\Backend\Controllers;

use App\Modules\Backend\Models\Verticals,
	App\Modules\Frontend\Models\Verticals as VerticalsCollection,
    App\Common\Lib\Application\Controllers\RESTController,
    App\Common\Lib\Application\Exceptions\HTTPException;


class VerticalsController extends RESTController{

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
	 * Verticals constructor
	 */
	public function __construct(){
		parent::__construct(false);
		$this->parseRequest($this->allowedFields, $this->allowedObjects);
	}
	
	/**
	 * @api {get} /verticals GET /verticals
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/verticals/?countryCode=ph&language=en&query={"status":"1"}&fields=id,name,description,status,active,created,modified,createdBy,modifiedBy&sort=-id,name&limit=10"
	 *
	 * @apiDescription Read data of all Verticals
	 * @apiName        Get
	 * @apiGroup       Verticals
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of verticals.
	 * 
	 * @apiSuccess     {String} id                       ID of the Vertical. 
	 * @apiSuccess     {String} name                     Name of the Vertical.
	 * @apiSuccess     {String} description              Description of the Vertical.
	 * @apiSuccess     {Number} status                   Status Flag of the Vertical.
	 * @apiSuccess     {Number} active                   Active Flag of the Vertical.
	 * @apiSuccess     {Date}   created                  Creation date of the Vertical.
	 * @apiSuccess     {Date}   modified                 Modification date of the Vertical.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Vertical.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Vertical.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "07f44e24-1d43-11e4-b32d-eff91066cccf",
     *       "name": "Money",
     *       "description": "Money",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-06 10:24:06",
     *       "modified": "2014-08-07 03:06:37",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     },
     *     {
     *       "id": "3140c21c-1d43-11e4-b32d-eff91066cccf",
     *       "name": "Insurance",
     *       "description": "Insurance",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-06 10:25:15",
     *       "modified": "2014-08-07 03:07:03",
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
		$vertical = new VerticalsCollection($this->di);
		return $this->respond($vertical);
	}
	
	/**
	 * @api {get} /verticals/:id GET /verticals/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/verticals/07f44e24-1d43-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Vertical
	 * @apiName        GetOne
	 * @apiGroup       Verticals
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Vertical unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Verticals unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Vertical.
	 * @apiSuccess     {String} name                     Name of the Vertical.
	 * @apiSuccess     {String} alias                    Alias of the Vertical.
	 * @apiSuccess     {String} description              Description of the Vertical.
	 * @apiSuccess     {Number} status                   Status of the Vertical.
     * @apiSuccess     {Number} active                   Flag of the Vertical.
	 * @apiSuccess     {Date}   created                  Creation date of the Vertical.
	 * @apiSuccess     {Date}   modified                 Modification date of the Vertical.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Vertical.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Vertical.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "07f44e24-1d43-11e4-b32d-eff91066cccf",
     *       "name": "Money",
     *       "description": "Money",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-06 10:24:06",
     *       "modified": "2014-08-07 03:06:37",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     }
	 *
	 * @apiError VerticalNotFound The id of the Vertical was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "VerticalNotFound"
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
			$vertical = new VerticalsCollection($this->di);
			$results = $this->respond($vertical, $id);
		}else{
			$results = VerticalsCollection::find(array(
				array("id" => $id)
			));
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Vertical does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * @api {post} /verticals POST /verticals
     * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/verticals/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "name=Telco&description=Telco&status=1"
	 * 
	 * @apiDescription  Create a new Vertical
	 * @apiName         Post
	 * @apiGroup        Verticals
	 *
	 * @apiHeader       {String} X-COMPARE-REST-API-KEY   Vertical unique access-key.
	 *
	 * @apiParam        {String} language                 Mandatory Language.
	 * @apiParam        {String} countryCode              Mandatory Country code.
	 * @apiParam        {String} name                     Mandatory Name of the Vertical.
	 * @apiParam        {String} [description]            Optional Description of the Vertical.
	 * @apiParam        {String} [alias]                  Optional Alias of the Vertical.
	 * @apiParam        {String} [status=0]               Optional Status of the Vertical.
	 * @apiParam        {String} [createdBy]              Optional ID of the User who created the Vertical.
	 * @apiParam        {String} [modifiedBy]             Optional ID of the User who modified the Vertical.
	 * 
	 * @apiSuccess      {String} id                       The new Vertical-ID.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "d49188a6-1d4e-11e4-b32d-eff91066cccf"
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
		
		if (!empty($data)) {
			$vertical = new Verticals();
			$data['id'] = $vertical->id;
			$data['name'] = isset($data['name']) ? $data['name'] : '';
			$data['description'] = isset($data['description']) ? $data['description'] : '';
			$data['status'] = isset($data['status']) ? $data['status'] : 0;
			if (isset($data['status'])) {
				$data['active'] =	($data['status'] != Verticals::ACTIVE) ? 0 : 1 ;
			}
			$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
			$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';
			
			if ($vertical->save($data)){
				$results['id'] = $vertical->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $vertical->getMessages(),
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
	 * @api {delete} /verticals/:id DELETE /verticals/:id
	 * @apiExample Example usage:
	 * curl -i -X DELETE "http://apibeta.compargo.com/v1/verticals/07f44e24-1d43-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Delete a Vertical
	 * @apiName        Delete
	 * @apiGroup       Verticals
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Vertical unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Vertical Unique ID.
	 *
	 * @apiSuccess {String} id                       The ID of Vertical.
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
	 * @apiError VerticalNotFound The id of the Vertical was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "VerticalNotFound"
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
		$vertical = Verticals::findFirstById($id);
		if (!$vertical){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Vertical does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		} else {
			if ($vertical->delete()){
				$results['id'] = $vertical->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $vertical->getMessages(),
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
		}
		return $results;
	}
 	
	/**
	 * @api {put} /verticals/:id PUT /verticals/:id
	 * @apiExample Example usage:
	 * curl -i -X PUT "http://apibeta.compargo.com/v1/verticals/07f44e24-1d43-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "name=Insurance&description=Insurance&status=1"
	 *      
	 * @apiDescription Update a Vertical
	 * @apiName  Put
	 * @apiGroup Verticals
	 *
	 * @apiHeader {String} X-COMPARE-REST-API-KEY   Vertical unique access-key.
	 *
	 * @apiParam  {String} language                 Mandatory Language.
	 * @apiParam  {String} countryCode              Mandatory Country Code.
	 * @apiParam  {String} id                       Mandatory Vertical Unique ID.
	 * @apiParam  {String} name                     Mandatory Name of the Vertical.
	 * @apiParam  {String} [description]            Optional Description of the Vertical.
	 * @apiParam  {String} [status]                 Optional Status of the Vertical.
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
	 * @apiError VerticalNotFound The id of the Vertical was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "VerticalNotFound"
	 *     }
	 */
	public function put($id){
		$results = $params = array();
		$request = $this->di->get('request');
		$data = $request->getPut();
		if (!empty($data)) {
			$vertical = Verticals::findFirstById($id);
			if (!$vertical){
				throw new HTTPException(
					"Not found",
					404,
					array(
						'dev' => 'Vertical does not exist',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			} else {
				$data['name'] = isset($data['name']) ? $data['name'] : $vertical->name;
				$data['description'] = isset($data['description']) ? $data['description'] : $vertical->description;
				$data['status'] = isset($data['status']) ? $data['status'] : $vertical->status;
				if (isset($data['status'])) {
					$data['active'] = ($data['status'] != Verticals::ACTIVE) ? 0 : 1 ;
				}
				$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : $vertical->createdBy;
				$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : $vertical->modifiedBy;
				
				if ($vertical->save($data)){
					$results['id'] = $vertical->id;
				}else{
					throw new HTTPException(
						"Request unable to be followed due to semantic errors",
						422,
						array(
							'dev' => $vertical->getMessages(),
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
	 * @api {post} /verticals/search POST /verticals/search
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/verticals/search/?countryCode=ph&language=en"
	 *      -d "query={"name":"Money","status":"1"}&fields=id,name,description,status,active,created,modified,createdBy,modifiedBy&
	 *          sort=-id,name&
	 *          limit=10"
	 * @apiDescription Read data of all Verticals
	 * @apiName    Searches
	 * @apiGroup   Verticals
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Vertical unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} [query]                  Optional query conditions that rows must satisfy to be selected.
	 * @apiParam   {String} [fields]                 Optional fields indicates a column that you want to retrieve.
	 * @apiParam   {String} [sort]                   Optional sort orders columns selected for output.
	 * @apiParam   {String} [limit=0]                Optional limit used to constrain the number of rows returned.
	 * 												 When offset parameter is present, the limit specifies the offset
	 *                                               of the first row to return.
	 *                                               When count parameter exists, the limit identifies all the rows returned and with default 0.
	 * @apiParam   {String} [offset]                 Optional offset specifies the maximum number of rows to return.
	 * @apiParam   {String} [count=1]                Optional count with default 1. Returns the count of areas.
	 *
	 * @apiSuccess {String} id                       ID of the Vertical.
	 * @apiSuccess {String} name                     Name of the Vertical.
	 * @apiSuccess {String} description              Description of the Vertical.
	 * @apiSuccess {Number} status                   Status of the Vertical.
	 * @apiSuccess {Number} active                   Active Flag of the Vertical.
	 * @apiSuccess {Date}   created                  Creation date of the Vertical.
	 * @apiSuccess {Date}   modified                 Modification date of the Vertical.
	 * @apiSuccess {String} createdBy                ID of the User who created the Vertical.
	 * @apiSuccess {String} modifiedBy               ID of the User who modified the Vertical.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "07f44e24-1d43-11e4-b32d-eff91066cccf",
     *       "name": "Money",
     *       "description": "Money",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-06 10:24:06",
     *       "modified": "2014-08-07 03:06:37",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     },
     *     {
     *       "id": "3140c21c-1d43-11e4-b32d-eff91066cccf",
     *       "name": "Insurance",
     *       "description": "Insurance",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-06 10:25:15",
     *       "modified": "2014-08-07 03:07:03",
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
	 */
	public function searches(){
		$vertical = new VerticalsCollection($this->di);
		return $this->respond($vertical);
	}
	
	/**
	 * @api {post} /verticals/search/:id POST /verticals/search/:id
     * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i -X POST"http://apibeta.compargo.com/v1/verticals/56c4b6c2-1d54-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 * @apiDescription Read data of a Vertical
	 * @apiName searchOne
	 * @apiGroup Verticals
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Verticals unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Vertical unique ID.
	 *
	 * @apiSuccess {String} id                       ID of the Vertical.
	 * @apiSuccess {String} name                     Name of the Vertical.
	 * @apiSuccess {String} description              Lastname of the Vertical.
	 * @apiSuccess {Number} status                   Status of the Vertical.
	 * @apiSuccess {Number} active                   Flag of the Vertical.
	 * @apiSuccess {Date}   created                  Creation date of the Vertical.
	 * @apiSuccess {Date}   modified                 Modification date of the Vertical.
	 * @apiSuccess {String} createdBy                ID of the User who created the Vertical.
	 * @apiSuccess {String} modifiedBy               ID of the User who modified the Vertical.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "07f44e24-1d43-11e4-b32d-eff91066cccf",
     *       "name": "Money",
     *       "description": "Money",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-06 10:24:06",
     *       "modified": "2014-08-07 03:06:37",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     }
	 *
	 * @apiError VerticalNotFound The id of the Vertical was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "VerticalNotFound"
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
	 */
	public function searchOne($id){
		$results = array();
		$request = $this->di->get('request');
		$parameters = $request->getPost();
		if (count($parameters) > 1) {
			$vertical = new VerticalsCollection($this->di);
			$results = $this->respond($vertical, $id);
		}else{
			$results = VerticalsCollection::find(array(
				array("id" => $id)
			));
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Vertical does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
}