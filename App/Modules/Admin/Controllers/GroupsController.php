<?php
namespace App\Modules\Admin\Controllers;

use \App\Modules\Admin\Models\Groups,
	\App\Common\Lib\Application\Controllers\RESTController,
	\App\Common\Lib\Application\Exceptions\HTTPException;

class GroupsController extends RESTController{

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
			'alias',	
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
			'alias',
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
			'alias',
			'status',
			'active',
			'created',
			'modified',
			'createdBy',
			'modifiedBy'
		),
		'whitelist' => array(
			'name',
			'description',
			'alias',
			'status'
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
	 * Initialize controller
	 *
	 * @return void
	 */
	public function __construct(){
		
		parent::__construct(false);
		
		$this->parseRequest($this->allowedFields, $this->allowedObjects);
		
	}
	
	/**
	 * @api {get} /admin/groups GET /groups
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/admin/groups/?countryCode=ph&language=en&query={"status":"1"}&fields=descriptions&sort=-id,name&limit=10"
	 *
	 * @apiDescription Read data of all Groups
	 * @apiName        GetGroups
	 * @apiGroup       Groups
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Groups unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of groups.
	 * 
	 * @apiSuccess     {Number} id                       ID of the Group.
	 * @apiSuccess     {String} name                     Name of the Group.
	 * @apiSuccess     {String} description              Description of the Group.
	 * @apiSuccess     {String} alias                    Alias of the Group.
	 * @apiSuccess     {String} status                   Status of the Group.
	 * @apiSuccess     {String} active                   Flag of the Group.
	 * @apiSuccess     {String} created                  Creation date of the Group.
	 * @apiSuccess     {String} modified                 Modification date of the Group.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Group.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Group.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "56c4b6c2-1d54-11e4-b32d-eff91066cccf",
	 *       "name": "Super Admin",
	 *       "description": "Super Administrator",
	 *       "alias": "super-admin",
	 *       "status": 1,
	 *       "active": 1,
	 *       "created": "2014-07-11 09:13:27",
	 *       "modified": "2014-07-11 09:52:08",
	 *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
	 *     },
	 *     {
	 *       "id": "574a5eb2-1d59-11e4-b32d-eff91066cccf",
	 *       "name": "Admin",
	 *       "description": "Administrator",
	 *       "alias": "admin",
	 *       "status": 1,
	 *       "active": 1,
	 *       "created": "2014-07-11 09:13:27",
	 *       "modified": "2014-07-11 09:52:08",
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
		$group = new Groups();
		return $this->respond($group);
	}

	/**
	 * @api {get} /admin/groups/:id GET /groups/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/admin/groups/56c4b6c2-1d54-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Group
	 * @apiName        GetGroup
	 * @apiGroup       Groups
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Groups unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode             Mandatory Country Code.
	 * @apiParam       {Number} id                       Mandatory Groups unique ID.
	 *
	 * @apiSuccess     {Number} id                       ID of the Group.
	 * @apiSuccess     {String} name                     Name of the Group.
	 * @apiSuccess     {String} alias                    Alias of the Group.
	 * @apiSuccess     {String} description              Description of the Group.
	 * @apiSuccess     {String} status                   Status of the Group.
     * @apiSuccess     {String} active                   Flag of the Group.
	 * @apiSuccess     {String} created                  Creation date of the Group.
	 * @apiSuccess     {String} modified                 Modification date of the Group.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Group.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Group.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "56c4b6c2-1d54-11e4-b32d-eff91066cccf",
	 *       "name": "Super Admin",
	 *       "description": "Super Administrator",
	 *       "alias": "super-admin",
	 *       "status": 1,
	 *       "active": 1,
	 *       "created": "2014-07-11 09:13:27",
	 *       "modified": "2014-07-11 09:52:08",
	 *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
	 *     }
	 *
	 * @apiError GroupNotFound The id of the Group was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "GroupNotFound"
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
		$results =  array();
		$request = $this->di->get('request');
		$parameters = $request->get();
		if (isset($parameters['query'])) {
			$group = new Groups();
			$results = $this->respond($id, $group);
		}else{
			$results = Groups::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Group does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}

	/**
	 * @api {post} /admin/groups POST /groups
     * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/admin/groups/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "name=User&description=User&status=1"
	 * 
	 * @apiDescription  Create a new Group
	 * @apiName         PostGroup
	 * @apiGroup        Groups
	 *
	 * @apiHeader       {String} X-COMPARE-REST-API-KEY   Groups unique access-key.
	 *
	 * @apiParam        {String} language                 Mandatory Language.
	 * @apiParam        {String} countryCode              Mandatory Country code.
	 * @apiParam        {String} name                     Mandatory Name of the Group.
	 * @apiParam        {String} [description]            Optional Description of the Group.
	 * @apiParam        {String} [alias]                  Optional Alias of the Group.
	 * @apiParam        {String} [status=0]               Optional Status of the Group.
	 *
	 * @apiSuccess      {String} id                       The new Group-ID.
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
 			$group = new Groups();
 			$data['id'] = $group->id;
 			$data['name'] = isset($data['name']) ? $data['name'] : '';
 			$data['description'] = isset($data['description']) ? $data['description'] : '';
 			$data['alias'] = isset($data['alias']) ? $data['alias'] : '';
 			$data['status'] = isset($data['status']) ? $data['status'] : 0;
 			$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
 			$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';
 			if (isset($data['status'])) {
 				$data['active'] = ($data['status'] != Groups::ACTIVE) ? 0 : 1 ;
 			}
 			
 			if ($group->create($data)){
 				$results['id'] = $group->id;
 			}else{
 				throw new HTTPException(
 					"Request unable to be followed due to semantic errors",
 					422,
 					array(
 						'dev' => $group->getMessages(),
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
	 * @api {delete} /admin/groups/:id DELETE /groups/:id
	 * @apiExample Example usage:
	 * curl -i -X DELETE "http://apibeta.compargo.com/v1/admin/groups/56c4b6c2-1d54-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Delete a Group
	 * @apiName        DeleteGroup
	 * @apiGroup       Groups
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Groups unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {Number} id                       Mandatory Groups Unique ID.
	 *
	 * @apiSuccess {String} id                       The ID of Group.
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
	 * @apiError GroupNotFound The id of the Group was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "GroupNotFound"
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
		$group = Groups::findFirstById($id);
		if ($group){
			if ($group->delete()){
				$results['id'] = $group->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $group->getMessages(),
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
		} else {
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Group does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
 
	/**
	 * @api {put} /admin/groups/:id PUT /groups/:id
	 * @apiExample Example usage:
	 * curl -i -X PUT "http://apibeta.compargo.com/v1/admin/groups/574a5eb2-1d59-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "name=User&description=User&status=1"
	 *      
	 * @apiDescription Update a Group
	 * @apiName  UpdateGroup
	 * @apiGroup Groups
	 *
	 * @apiHeader {String} X-COMPARE-REST-API-KEY   Groups unique access-key.
	 *
	 * @apiParam  {String} language                 Mandatory Language.
	 * @apiParam  {String} countryCode              Mandatory Country Code.
	 * @apiParam  {Number} id                       Mandatory Group Unique ID.
	 * @apiParam  {String} name                     Mandatory Name of the Group.
	 * @apiParam  {String} [description]            Optional Description of the Group.
	 * @apiParam  {String} [alias]                  Optional Alias of the Group.
	 * @apiParam  {String} [status]                 Optional Status of the Group.
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
	 * @apiError GroupNotFound The id of the Group was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "GroupNotFound"
	 *     }
	 */
	public function put($id){
		$results = array();
 		$request = $this->di->get('request');
 		$data = $request->getPut();
 		
 		if (!empty($data)) {
 			$group = Groups::findFirstById($id);
 			if (!$group){
 				throw new HTTPException(
 					"Not found",
 					404,
 					array(
 						'dev' => 'Group does not exist',
 						'internalCode' => 'P1000',
 						'more' => '' // Could have link to documentation here.
 					)
 				);
 			} else {
 				$data['name'] = isset($data['name']) ? $data['name'] : $group->name;
 				$data['description'] = isset($data['description']) ? $data['description'] : $group->description;
 				$data['alias'] = isset($data['alias']) ? $data['alias'] : '';
 				$data['status'] = isset($data['status']) ? $data['status'] : $group->status;
 				$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : $group->createdBy;
 				$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : $group->modifiedBy;
 				if (isset($data['status'])) {
 					$data['active'] = ($data['status'] != Groups::ACTIVE) ? 0 : 1;
 				}
 				if ($group->save($data)){
 					$results['id'] = $group->id;
 				}else{
 					throw new HTTPException(
 						"Request unable to be followed due to semantic errors",
 						422,
 						array(
 							'dev' => $group->getMessages(),
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
	 * @api {post} /admin/groups/search POST /groups/search
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/admin/groups/?countryCode=ph&language=en"
	 *      -d "query={"name":"Admin","status":"1"}&fields=descriptions&sort=-id,name&limit=10"
	 * @apiDescription Read data of all Groups
	 * @apiName    SearchGroups
	 * @apiGroup   Groups
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Groups unique access-key.
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
	 * @apiParam   {String} [count=1]                Optional count with default 1. Returns the count of groups.
	 *
	 * @apiSuccess {Number} id                       ID of the Group.
	 * @apiSuccess {String} name                     Name of the Group.
	 * @apiSuccess {String} description              Description of the Group.
	 * @apiSuccess {String} alias                    Alias of the Group.
	 * @apiSuccess {String} status                   Status of the Group.
	 * @apiSuccess {String} active                   Flag of the Group.
	 * @apiSuccess {String} created                  Creation date of the Group.
	 * @apiSuccess {String} modified                 Modification date of the Group.
	 * @apiSuccess {String} createdBy                ID of the User who created the Group.
	 * @apiSuccess {String} modifiedBy               ID of the User who modified the Group.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "56c4b6c2-1d54-11e4-b32d-eff91066cccf",
	 *       "name": "Super Admin",
	 *       "description": "Super Administrator",
	 *       "alias": "super-admin",
	 *       "status": 1,
	 *       "active": 1,
	 *       "created": "2014-07-11 09:13:27",
	 *       "modified": "2014-07-11 09:52:08",
	 *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *     },
	 *     {
	 *       "id": "574a5eb2-1d59-11e4-b32d-eff91066cccf",
	 *       "name": "Admin",
	 *       "description": "Administrator",
	 *       "alias": "admin",
	 *       "status": 1,
	 *       "active": 1,
	 *       "created": "2014-07-11 09:13:27",
	 *       "modified": "2014-07-11 09:52:08",
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
	public function search(){
		$group = new Groups();
		return $this->respond($group);
	}

	/**
	 * @api {post} /admin/groups/search/:id POST /groups/search/:id
     * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i -X POST"http://apibeta.compargo.com/v1/admin/groups/56c4b6c2-1d54-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 * @apiDescription Read data of a Group
	 * @apiName SearchGroup
	 * @apiGroup Groups
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Groups unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {Number} id                       Mandatory Groups unique ID.
	 *
	 * @apiSuccess {Number} id                       ID of the Group.
	 * @apiSuccess {String} name                     Name of the Group.
	 * @apiSuccess {String} description              Description of the Group.
	 * @apiSuccess {String} alias                    Alias of the Group.
	 * @apiSuccess {String} status                   Status of the Group.
	 * @apiSuccess {String} active                   Flag of the Group.
	 * @apiSuccess {String} created                  Creation date of the Group.
	 * @apiSuccess {String} modified                 Modification date of the Group.
	 * @apiSuccess {String} createdBy                ID of the User who created the Group.
	 * @apiSuccess {String} modifiedBy               ID of the User who modified the Group.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "56c4b6c2-1d54-11e4-b32d-eff91066cccf",
	 *       "name": "Super Admin",
	 *       "description": "Super Administrator",
	 *       "alias": "super-admin",
	 *       "status": 1,
	 *       "active": 1,
	 *       "created": "2014-07-11 09:13:27",
	 *       "modified": "2014-07-11 09:52:08",
	 *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
	 *     }
	 *
	 * @apiError GroupNotFound The id of the Group was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "GroupNotFound"
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
		if (isset($parameters['query']) > 1) {
			$group = new Groups();
			$results = $this->respond($id, $group);
		}else{
			$results = Groups::findFirstById($id);
		}
		return $results;
	}
}