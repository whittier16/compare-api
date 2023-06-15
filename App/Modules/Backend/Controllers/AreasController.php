<?php
namespace App\Modules\Backend\Controllers;

use App\Modules\Backend\Models\Areas,
	App\Modules\Frontend\Models\Areas as AreasCollection,
	App\Common\Lib\Application\Controllers\RESTController,
    App\Common\Lib\Application\Exceptions\HTTPException;

class AreasController extends RESTController{

	/**
	 * Sets which fields may be searched against, and which fields are allowed to be returned in
	 * partial responses. 
	 * @var array
	 */
	protected $allowedFields = array(
		'search' => array(
				'id',
				'name',
				'category',
				'description',
				'language',
				'bounds',
	            'parentId',
				'lft',
				'rght',
				'scope',
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
				'category',
				'description',
				'language',
				'bounds',
	            'parentId',
				'lft',
				'rght',
				'scope',
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
				'category',
				'description',
				'language',
				'bounds',
	            'parentId',
				'lft',
				'rght',
				'scope',
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
	 * Areas constructor
	 */
	public function __construct(){
		parent::__construct(false);
		$this->parseRequest($this->allowedFields, $this->allowedObjects);
	}
	
	/**
	 * @api {get} /areas GET /areas
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/areas/?countryCode=ph&language=en&query={"status":"1"}&fields=descriptions&sort=-id,name&limit=10"
	 *
	 * @apiDescription Read data of all Areas
	 * @apiName        Get
	 * @apiGroup       Areas
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Areas unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of areas.
	 * 
	 * @apiSuccess     {String} id                       ID of the Area. 
	 * @apiSuccess     {String} name                     Name of the Area.
	 * @apiSuccess     {String} category                 Category of the Area.
	 * @apiSuccess     {String} description              Description of the Area.
	 * @apiSuccess     {String} bounds                   Bounds of the Area. 
	 * @apiSuccess     {String} parentId                 Parent ID of the Area.
	 * @apiSuccess     {String} lft                      Lft of the Area.
	 * @apiSuccess     {String} rght                     Rght of the Area.
	 * @apiSuccess     {String} scope                    Scope of the Area.
	 * @apiSuccess     {Number} editable                 Editable Flag of the Area.
	 * @apiSuccess     {Number} visibility               Visibility Flag of the Area.
	 * @apiSuccess     {Number} status                   Status Flag of the Area.
	 * @apiSuccess     {Number} active                   Active Flag of the Area.
	 * @apiSuccess     {Date}   created                  Creation date of the Area.
	 * @apiSuccess     {Date}   modified                 Modification date of the Area.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Area.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Area.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "337b6f34-2282-11e4-b700-0b28aad944c8",
     *       "name": "NCR",
     *       "category": "Region",
     *       "description": "National Capital Region (NCR) of the Philippines, is the seat of government and the most populous region and metropolitan area of the country which is composed of the City of Manila and the cities of Caloocan, Las Pi–as, Makati, Malabon, Mandaluyong, Marikina, Muntinlupa, Navotas, Para–aque, Pasay, Pasig, Quezon City, San Juan, Taguig, and Valenzuela, as well as the Municipality of Pateros.",
     *       "language": "en",
     *       "bounds": "",
     *       "parentId": "",
     *       "lft": "",
     *       "rght": "",
     *       "scope": "",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-13 02:38:53",
     *       "modified": "2014-08-13 02:42:55",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     },
	 *     {
     *       "id": "4b639068-319b-11e4-988c-7d9574853fac",
     *       "name": "CALABARZON",
     *       "category": "Region",
     *       "description": "CALABARZON is one of the regions of the Philippines. It is designated as Region IV-A and its regional center is Calamba City in Laguna. The region is composed of five provinces, namely: Cavite, Laguna, Batangas, Rizal, and Quezon; whose names form the acronym CALABARZON. The region is also more formally known as Southern Tagalog Mainland.",
     *       "language": "en",
     *       "bounds": null,
     *       "parentId": null,
     *       "lft": null,
     *       "rght": null,
     *       "scope": null,
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-09-01 07:46:18",
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
		$area = new AreasCollection($this->di);
		return $this->respond($area);
	}
	
		/**
	 * @api {get} /areas/:id GET /areas/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/areas/337b6f34-2282-11e4-b700-0b28aad944c8/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Area
	 * @apiName        GetOne
	 * @apiGroup       Areas
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Areas unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {Number} countryCode              Mandatory Country Code.
	 * @apiParam       {Number} id                       Mandatory Area unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Area. 
	 * @apiSuccess     {String} name                     Name of the Area.
	 * @apiSuccess     {String} category                 Category of the Area.
	 * @apiSuccess     {String} description              Description of the Area.
	 * @apiSuccess     {String} bounds                   Bounds of the Area. 
	 * @apiSuccess     {String} parentId                 Parent ID of the Area.
	 * @apiSuccess     {String} lft                      Lft of the Area.
	 * @apiSuccess     {String} rght                     Rght of the Area.
	 * @apiSuccess     {String} scope                    Scope of the Area.
	 * @apiSuccess     {Number} editable                 Editable Flag of the Area.
	 * @apiSuccess     {Number} visibility               Visibility Flag of the Area.
	 * @apiSuccess     {Number} status                   Status Flag of the Area.
	 * @apiSuccess     {Number} active                   Active Flag of the Area.
	 * @apiSuccess     {Date}   created                  Creation date of the Area.
	 * @apiSuccess     {Date}   modified                 Modification date of the Area.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Area.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Area.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "337b6f34-2282-11e4-b700-0b28aad944c8",
     *       "name": "NCR",
     *       "category": "Region",
     *       "description": "National Capital Region (NCR) of the Philippines, is the seat of government and the most populous region and metropolitan area of the country which is composed of the City of Manila and the cities of Caloocan, Las Pi–as, Makati, Malabon, Mandaluyong, Marikina, Muntinlupa, Navotas, Para–aque, Pasay, Pasig, Quezon City, San Juan, Taguig, and Valenzuela, as well as the Municipality of Pateros.",
     *       "language": "en",
     *       "bounds": "",
     *       "parentId": "",
     *       "lft": "",
     *       "rght": "",
     *       "scope": "",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-13 02:38:53",
     *       "modified": "2014-08-13 02:42:55",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     }
	 *
	 * @apiError AreaNotFound The id of the Area was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "AreaNotFound"
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
			$area = new AreasCollection($this->di);
			$results = $this->respond($area, $id);
		}else{
			$results = AreasCollection::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Area does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}

	/**
	 * @api {post} /areas POST /areas
     * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/areas/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "name=Central%20Visayas&
	 *      	category=Region&
	 *          description=Central%20Visayas%20is%20a%20region%20of%20the%20Philippines,%20designated%20as%20Region%20VII.%20It%20is%20located%20in%20the%20central%20part%20of%20the%20Visayas%20island%20group,%20and%20consists%20of%20four%20provincesÑBohol,%20Cebu,%20Negros%20Oriental,%20and%20SiquijorÑ%20and%20the%20highly%20urbanized%20cities%20of%20Cebu%20City,%20Lapu-Lapu%20City,%20and%20Mandaue%20City.%20The%20region%20is%20dominated%20by%20the%20native%20speakers%20of%20Cebuano.%20Cebu%20City%20is%20its%20regional%20center.&
	 *          language=en&
	 *          editable=1&
	 *          visibility=1&      
	 *          status=1"
	 * 
	 * @apiDescription  Create a new Area
	 * @apiName         Post
	 * @apiGroup        Areas
	 *
	 * @apiHeader       {String} X-COMPARE-REST-API-KEY   Area unique access-key.
	 *
	 * @apiParam        {String} language                 Mandatory Language.
	 * @apiParam        {String} countryCode              Mandatory Country code.
	 * @apiParam        {String} name                     Mandatory Name of the Area.
	 * @apiParam        {String} category                 Mandatory Category of the Area.
	 * @apiParam        {String} language                 Mandatory Language of the Area.
	 * @apiParam        {String} [description]            Optional Description of the Area.
	 * @apiParam        {String} [bounds]                 Optional Bounds of the Area. 
	 * @apiParam        {String} [parentId]               Optional Parent ID of the Area.
	 * @apiParam        {String} [lft]                    Optional Lft of the Area.
	 * @apiParam        {String} [rght]                   Optional Rght of the Area.
	 * @apiParam        {String} [scope=0]                Optional Scope of the Area.
	 * @apiParam        {String} [editable=0]             OptionalEditable Flag of the Area.
	 * @apiParam        {String} [visibility=0]           Optional Visibility Flag of the Area.
	 * @apiParam        {String} [status=0]               Optional Status Flag of the Area.
	 *
	 * @apiSuccess      {String} id                       The new Area-ID.
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
		
		if (!empty($data)){
			$area = new Areas();
			$data['id'] = $area->id;
			$data['name'] = isset($data['name']) ? $data['name'] : '';
			$data['category'] = isset($data['category']) ? $data['category'] : '';
			$data['description'] = isset($data['description']) ? $data['description'] : '';
			$data['language'] = isset($data['language']) ? $data['language'] : '';
			$data['bounds'] = isset($data['bounds']) ? $data['bounds'] : '';
			$data['parentId'] = isset($data['parentId']) ? $data['parentId'] : '';
			$data['lft'] = isset($data['lft']) ? $data['lft'] : '';
			$data['rght'] = isset($data['rght']) ? $data['rght'] : '';
			$data['scope'] = isset($data['scope']) ? $data['scope'] : '';
			$data['status'] = isset($data['status']) ? $data['status'] : 0;
			if (isset($data['status'])) {
				$data['active'] = ($data['status'] != Areas::ACTIVE) ? 0 : 1 ;
			}
			$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
			$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';
			if ($area->create($data)){
				$results['id'] = $area->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $area->getMessages(),
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
	 * @api {delete} /areas/:id DELETE /areas/:id
	 * @apiExample Example usage:
	 * curl -i -X DELETE "http://apibeta.compargo.com/v1/areas/4b639068-319b-11e4-988c-7d9574853fac/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Delete an Area
	 * @apiName        Delete
	 * @apiGroup       Areas
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Areas unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Area Unique ID.
	 *
	 * @apiSuccess {String} id                       The ID of Area.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "4b639068-319b-11e4-988c-7d9574853fac"
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
	 * @apiError AreaNotFound The id of the Area was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "AreaNotFound"
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
		$area = Areas::findFirstById($id);
		if (!$area){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Area does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		} else {
			if ($area->delete()){
				$results['id'] = $area->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $area->getMessages(),
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
		}
		return $results;
	}
 	
	/**
	 * @api {put} /areas/:id PUT /areas/:id
	 * @apiExample Example usage:
	 * curl -i -X PUT "http://apibeta.compargo.com/v1/areas/4b639068-319b-11e4-988c-7d9574853fac/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "name=Western%20Visayas&status=1"
	 *      
	 * @apiDescription Update an Area
	 * @apiName        Update
	 * @apiGroup       Areas
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Areas unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Area Unique ID.
	 * @apiParam       {String} name                     Mandatory Name of the Area.
	 * @apiParam       {String} category                 Mandatory Category of the Area.
	 * @apiParam       {String} language                 Mandatory Language of the Area.
	 * @apiParam       {String} [description]            Optional Description of the Area.
	 * @apiParam       {String} [bounds]                 Optional Bounds of the Area. 
	 * @apiParam       {String} [parentId]               Optional Parent ID of the Area.
	 * @apiParam       {String} [lft]                    Optional Lft of the Area.
	 * @apiParam       {String} [rght]                   Optional Rght of the Area.
	 * @apiParam       {Number} [scope=0]                Optional Scope of the Area.
	 * @apiParam       {Number} [editable=0]             OptionalEditable Flag of the Area.
	 * @apiParam       {Number} [visibility=0]           Optional Visibility Flag of the Area.
	 * @apiParam       {Number} [status=0]               Optional Status Flag of the Area.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "574a5eb2-1d59-11e4-b32d-eff91066cccf"
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
	 * @apiError AreaNotFound The id of the Area was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "AreaNotFound"
	 *     }
	 */
	public function put($id){
		$results = $params = array();
		$request = $this->di->get('request');
		$data = $request->getPut();
		if (!empty($data)) {
			$area = Areas::findFirstById($id);
			if (!$area){
				throw new HTTPException(
					"Not found",
					404,
					array(
						'dev' => 'Area does not exist',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			} else {
				$data['name'] = isset($data['name']) ? $data['name'] : $area->name;
				$data['category'] = isset($data['category']) ? $data['category'] : $area->category;
				$data['description'] = isset($data['description']) ? $data['description'] : $area->description;
				$data['language'] = isset($data['language']) ? $data['language'] : $area->language;
				$data['bounds'] = isset($data['bounds']) ? $data['bounds'] : $area->bounds;
				$data['parentId'] = isset($data['parentId']) ? $data['parentId'] : $area->parentId;
				$data['lft'] = isset($data['lft']) ? $data['lft'] : $area->lft;
				$data['rght'] = isset($data['rght']) ? $data['rght'] : $area->rght;
				$data['scope'] = isset($data['scope']) ? $data['scope'] : $area->scope;
				$data['status'] = isset($data['status']) ? $data['status'] : $area->status;
				if (isset($data['status'])) {
					$data['active'] = ($data['status'] != Areas::ACTIVE) ? 0 : 1 ;
				}
				if ($area->save($data)){
					$results['id'] = $area->id;
				}else{
					throw new HTTPException(
						"Request unable to be followed due to semantic errors",
						422,
						array(
							'dev' => $area->getMessages(),
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
	 * @api {post} /areas/search POST /areas/search
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/areas/?countryCode=ph&language=en"
	 *      -d "query={"name":"Eastern%20Visayas", "status":"1"}&fields=descriptions&sort=-id,name&limit=10"
	 * @apiDescription Read data of all Areas
	 * @apiName        Search
	 * @apiGroup       Areas
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Areas unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} [query]                  Optional query conditions that rows must satisfy to be selected.
	 * @apiParam       {String} [fields]                 Optional fields indicates a column that you want to retrieve.
	 * @apiParam       {String} [sort]                   Optional sort orders columns selected for output.
	 * @apiParam       {String} [limit=0]                Optional limit used to constrain the number of rows returned.
	 * 					   							     When offset parameter is present, the limit specifies the offset
	 *                                                   of the first row to return.
	 *                                                   When count parameter exists, the limit identifies all the rows returned and with default 0.
	 * @apiParam       {String} [offset]                 Optional offset specifies the maximum number of rows to return.
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of areas.
	 *
	 * @apiSuccess     {String} id                       ID of the Area. 
	 * @apiSuccess     {String} name                     Name of the Area.
	 * @apiSuccess     {String} category                 Category of the Area.
	 * @apiSuccess     {String} description              Description of the Area.
	 * @apiSuccess     {String} bounds                   Bounds of the Area. 
	 * @apiSuccess     {String} parentId                 Parent ID of the Area.
	 * @apiSuccess     {String} lft                      Lft of the Area.
	 * @apiSuccess     {String} rght                     Rght of the Area.
	 * @apiSuccess     {String} scope                    Scope of the Area.
	 * @apiSuccess     {Number} editable                 Editable Flag of the Area.
	 * @apiSuccess     {Number} visibility               Visibility Flag of the Area.
	 * @apiSuccess     {Number} status                   Status Flag of the Area.
	 * @apiSuccess     {Number} active                   Active Flag of the Area.
	 * @apiSuccess     {Date}   created                  Creation date of the Area.
	 * @apiSuccess     {Date}   modified                 Modification date of the Area.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Area.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Area.
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
		$area = new AreasCollection($this->di);
		return $this->respond($area);
	}
	
	/**
	 * @api {post} /areas/search/:id POST /areas/search/:id
     * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i -X POST"http://apibeta.compargo.com/v1/areas/56c4b6c2-1d54-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 * @apiDescription Read data of an Area
	 * @apiName        SearchOne
	 * @apiGroup       Areas
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Areas unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Area unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Area. 
	 * @apiSuccess     {String} name                     Name of the Area.
	 * @apiSuccess     {String} category                 Category of the Area.
	 * @apiSuccess     {String} description              Description of the Area.
	 * @apiSuccess     {String} bounds                   Bounds of the Area. 
	 * @apiSuccess     {String} parentId                 Parent ID of the Area.
	 * @apiSuccess     {String} lft                      Lft of the Area.
	 * @apiSuccess     {String} rght                     Rght of the Area.
	 * @apiSuccess     {String} scope                    Scope of the Area.
	 * @apiSuccess     {Number} editable                 Editable Flag of the Area.
	 * @apiSuccess     {Number} visibility               Visibility Flag of the Area.
	 * @apiSuccess     {Number} status                   Status Flag of the Area.
	 * @apiSuccess     {Number} active                   Active Flag of the Area.
	 * @apiSuccess     {Date}   created                  Creation date of the Area.
	 * @apiSuccess     {Date}   modified                 Modification date of the Area.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Area.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Area.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "337b6f34-2282-11e4-b700-0b28aad944c8",
     *       "name": "NCR",
     *       "category": "Region",
     *       "description": "National Capital Region (NCR) of the Philippines, is the seat of government and the most populous region and metropolitan area of the country which is composed of the City of Manila and the cities of Caloocan, Las Pi–as, Makati, Malabon, Mandaluyong, Marikina, Muntinlupa, Navotas, Para–aque, Pasay, Pasig, Quezon City, San Juan, Taguig, and Valenzuela, as well as the Municipality of Pateros.",
     *       "language": "en",
     *       "bounds": "",
     *       "parentId": "",
     *       "lft": "",
     *       "rght": "",
     *       "scope": "",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-13 02:38:53",
     *       "modified": "2014-08-13 02:42:55",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     }
	 *
	 * @apiError AreaNotFound The id of the Area was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "AreaNotFound"
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
		$request = $this->di->get('requestBody');
		$parameters = $request->get();
		if (count($parameters) > 1) {
			$area = new AreasCollection($this->di);
			$results = $this->respond($id, $area);
		}else{
			$results = AreasCollection::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Area does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
}