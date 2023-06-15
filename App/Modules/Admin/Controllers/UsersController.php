<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\Users,
	App\Common\Lib\Application\Controllers\RESTController,
	App\Common\Lib\Application\Exceptions\HTTPException;

class UsersController extends RESTController{

	/**
	 * Sets which fields may be searched against, and which fields are allowed to be returned in
	 * partial responses. 
	 * @var array
	 */
	protected $allowedFields = array(
		'search' => array(
			'id',
			'groupId', 
			'emailAddress', 
			'firstName',
			'lastName',
			'password',
			'status',
			'active',	
			'created',
			'modified',
			'createdBy',
			'modifiedBy'
		),
		'partials' => array(
			'id',
			'groupId', 
			'emailAddress', 
			'firstName',
			'lastName',
			'password',
			'status',
			'active',	
			'created',
			'modified',
			'createdBy',
			'modifiedBy'
		),
		'sort' => array(
			'id',
			'groupId', 
			'emailAddress', 
			'firstName',
			'lastName',
			'password',
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
		'groups'
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
	 * @api {get} /admin/users GET /users
	 * @apiExample Example usage:
     * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
     *      -i "http://apibeta.compargo.com/v1/admin/users/?countryCode=dk&language=da&query={"lastName":"Doe","status":"1"}&fields=firstName,lastName,emailAddress&sort=-id,firstName&limit=10"
     *     			 
	 * @apiDescription Read data of all Users
	 * @apiName        GetUsers
	 * @apiGroup       Users
	 * 
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Users unique access-key.
	 * 
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} [query]                  Optional query conditions that rows must satisfy to be selected.
	 * @apiParam       {String} [fields]                 Optional fields indicates a column that you want to retrieve.
	 * @apiParam       {String} [sort]                   Optional sort orders columns selected for output.
	 * @apiParam       {String} [limit=0]                Optional limit used to constrain the number of rows returned.
	 * 													 When offset parameter is present, the limit specifies the offset 
	 *                                                   of the first row to return.
	 *                                                   When count parameter exists, the limit identifies all the rows returned and with default 0.
	 * @apiParam       {String} [offset]                 Options offset specifies the maximum number of rows to return.
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of users.
	 * 
	 * @apiSuccess     {Number} id                       ID of the User.
	 * @apiSuccess     {Number} groupId                  ID of the Group. 
	 * @apiSuccess     {String} emailAddre ss            Email Address of the User.
	 * @apiSuccess     {String} firstName                Firstname of the User.
	 * @apiSuccess     {String} lastName                 Lastname of the User.
	 * @apiSuccess     {String} password                 Password of the User.
	 * @apiSuccess     {String} status                   Status of the User.
	 * @apiSuccess     {String} active                   Flag of the User.
	 * @apiSuccess     {String} created                  Creation date of the User.
	 * @apiSuccess     {String} modified                 Modification date of the User.
	 * @apiSuccess     {String} createdBy                ID of the User who created the User.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the User.
	 * 
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "groupId": "56c4b6c2-1d54-11e4-b32d-eff91066cccf",
	 *       "emailAddress": "john.doe@moneymax.ph",
	 *       "firstName": "John",
	 *       "lastName": "Doe",
	 *       "status": "1",      
	 *       "active": "1",
	 *       "created": "2014-07-11 09:13:27",
     *       "modified": "2014-07-11 09:52:08",
	 *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"       
	 *     },
	 *     {
	 *       "id": "c6bcb740-1dcc-11e4-b32d-eff91066cccf",
	 *       "groupId": "56c4b6c2-1d54-11e4-b32d-eff91066cccf",
	 *       "emailAddress": "mary@moneymax.ph",
	 *       "firstName": "Mary",
	 *       "lastName": "Doe",
	 *       "status": "1",
	 *       "active": "1",      
	 *       "created": "2014-07-11 09:13:27",
     *       "modified": "2014-07-11 09:52:08"
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "c6bcb740-1dcc-11e4-b32d-eff91066cccf"       
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

	public function get(){
		$user = new Users();
		return $this->respond($user);
	}

	/**
	 * @api {get} /admin/users/:id GET /users/:id
 	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/admin/users/c6bcb740-1dcc-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a User
	 * @apiName        GetUser
	 * @apiGroup       Users
	 * 
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Users unique access-key.
	 * 
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {Number} id                       Mandatory Users Unique ID.
	 * 
	 * @apiSuccess     {Number} id                       ID of the User.
	 * @apiSuccess     {Number} groupId                  ID of the Group. 
	 * @apiSuccess     {String} emailAddress             Email Address of the User.
	 * @apiSuccess     {String} firstName                Firstname of the User.
	 * @apiSuccess     {String} lastName                 Lastname of the User.
	 * @apiSuccess     {String} password                 Password of the User.
	 * @apiSuccess     {String} status                   Status of the User.
	 * @apiSuccess     {String} active                   Flag of the User.
	 * @apiSuccess     {String} created                  Creation date of the User.
	 * @apiSuccess     {String} modified                 Modification date of the User.
	 * @apiSuccess     {String} createdBy                ID of the User who created the User.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the User.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "c6bcb740-1dcc-11e4-b32d-eff91066cccf",
	 *       "groupId": "56c4b6c2-1d54-11e4-b32d-eff91066cccf",
	 *       "emailAddress": "john.doe@moneymax.ph",
	 *       "firstName": "John",
	 *       "lastName": "Doe",
	 *       "status": 0,
	 *       "active": 0,
	 *       "created": "2014-07-11 09:13:27",
	 *       "modified": "2014-07-11 09:52:08",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "c6bcb740-1dcc-11e4-b32d-eff91066cccf"       

	 *     }
	 *     
	 * @apiError UserNotFound The id of the User was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
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
		$results = array();
		$request = $this->di->get('request');
		$parameters = $request->get();
		if (isset($parameters['query'])) {
			$user = new Users();
			$results = $this->respond($id, $user);
		}else{
			$results = Users::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'User does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}

	/**
	 * @api {post} /admin/users POST /users
	 * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/admin/users/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "groupId=56c4b6c2-1d54-11e4-b32d-eff91066cccf&emailAddress=steve@moneymax.ph&firstName=Steve&lastName=Jobs&password=secret&status=1"

	 * @apiDescription  Create a new User
	 * @apiName         PostUser
	 * @apiGroup        Users
	 *
	 * @apiHeader       {String} X-COMPARE-REST-API-KEY   Users unique access-key.
	 * 
	 * @apiParam        {String} language                 Mandatory Language.
	 * @apiParam        {String} countryCode              Mandatory Country code.
	 * 
	 * @apiParam        {Number} groupId                  Mandatory ID of the Group. 
	 * @apiParam        {String} emailAddress             Mandatory Email Address of the User.
	 * @apiParam        {String} firstName                Mandatory Firstname of the User.
	 * @apiParam        {String} lastName                 Mandatory Lastname of the User.
	 * @apiParam        {String} password                 Mandatory Password of the User.
	 * @apiParam        {String} status                   Mandatory Status of the User.
	 * 
	 * @apiSuccess      {String} id                       The new Users-ID.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "1535ebcc-22b8-11e4-bd33-17609cecca2f"       
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
	 * @apiError UserNotFound The id of the User was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
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
			$user = new Users();
			$data['groupId'] = isset($data['groupId']) ? $data['groupId'] : $user->groupId;
			
			if (isset($data['password'])){
				$salt = $this->security->getTokenKey();
				$password = $salt . $data['password'];
				$passwordHash = create_hash($password);
				$user->password = sha1($salt . $data['password']);
				$user->salt = $salt;
				$user->hash = $passwordHash;
				$data['password'] = $user->password;
			}
			
			$data['id'] = $user->id;
			$data['emailAddress'] = isset($data['emailAddress']) ? $data['emailAddress'] : $user->emailAddress;
			$data['firstName'] = isset($data['firstName']) ? $data['firstName'] : $user->firstName;
			$data['lastName'] = isset($data['lastName']) ? $data['lastName'] : $user->lastName;
			$data['status'] = isset($data['status']) ? $data['status'] : 0;
			$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
			$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';
			
			if (isset($data['status'])) {
				$data['active'] =	($data['status'] != Users::ACTIVE) ? 0 : 1 ;
			}
			
			if ($user->create($data)){
				$results['id'] = $user->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
							'dev' => $user->getMessages(),
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
	 * @api {delete} /admin/users/:id DELETE /users/:id
	 * @apiExample Example usage:
	 * curl -i -X DELETE "http://apibeta.compargo.com/v1/admin/users/a8838d12-1dcc-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Delete a User
	 * @apiName DeleteUser
	 * @apiGroup Users
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Users unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory language.
	 * @apiParam   {String} countryCode              Mandatory country code.
	 * @apiParam   {Number} id                       Mandatory Users unique ID.
	 *
	 * @apiSuccess {String} id                       The id of User.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
	 *     }
	 *
	 * @apiError UserNotFound The id of the User was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
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
	public function delete($id){
		$results = array();
		$user = Users::findFirstById($id);
		if ($user){
			if ($user->delete()){
				$results['id'] = $user->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $user->getMessages(),
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
					'dev' => 'User does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
 
 	/**
	 * @api {put} /admin/users/:id PUT /users/:id
	 * @apiExample Example usage:
	 * curl -i -X PUT "http://apibeta.compargo.com/v1/admin/users/c6bcb740-1dcc-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "lastName=Maden"
	 * @apiDescription Update a User
	 * @apiName  UpdateUser
	 * @apiGroup Users
	 *
	 * @apiHeader {String} X-COMPARE-REST-API-KEY   Users unique access-key.
	 * 
	 * @apiParam  {String} language                 Mandatory language.
	 * @apiParam  {String} countryCode              Mandatory country code.
	 * @apiParam  {Number} id                       Mandatory Users unique ID.
	 * @apiParam  {Number} [groupId]                Optional ID of the Group. 
	 * @apiParam  {String} [emailAddress]           Optional Email Address of the User.
	 * @apiParam  {String} [firstName]              Optional Firstname of the User.
	 * @apiParam  {String} [lastName]               Optional Lastname of the User.
	 * @apiParam  {String} [password]               Optional Password of the User.
	 * @apiParam  {String} [status]                 Optional Status of the User.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "1"
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
	 * @apiError UserNotFound The id of the User was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
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
	 public function put($id){
		$results = $data = array();
		$request = $this->di->get('request');
		$data = $request->getPut();
			
		if (!empty($data)) {
			$user = Users::findFirstById($id);
			if (!$user){
				throw new HTTPException(
					"Not found",
					404,
					array(
						'dev' => 'User does not exist',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			} else {
				$data['groupId'] = isset($data['groupId']) ? $data['groupId'] : $user->groupId;
				if (isset($data['password'])){
					$salt = $this->security->getTokenKey();
					$passwordHash = create_hash($salt . $data['password']);
						
					$user->password = sha1($salt . $data['password']);
					$user->salt = $salt;
					$user->hash = $passwordHash;
					$data['password'] = $user->password;
				}
					
				$data['emailAddress'] = isset($data['emailAddress']) ? $data['emailAddress'] : $user->emailAddress;
				$data['firstName'] = isset($data['firstName']) ? $data['firstName'] : $user->firstName;
				$data['lastName'] = isset($data['lastName']) ? $data['lastName'] : $user->lastName;
				$data['status'] = isset($data['status']) ? $data['status'] : $user->status;
				if (isset($data['status'])) {
					$data['active'] =	($data['status'] != Users::ACTIVE) ? 0 : 1 ;
				}
				$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : $user->createdBy;
				$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : $user->modifiedBy;
				
				if ($user->update($data)){
					$results['id'] = $user->id;
				} else {
					throw new HTTPException(
						"Request unable to be followed due to semantic errors",
						422,
						array(
							'dev' => $user->getMessages(),
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
	 * @api {post} /admin/users/search POST /users/search
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
     *      -i -X POST "http://apibeta.compargo.com/v1/admin/users/?countryCode=dk&language=da"
     *      -d "query={"lastName":"Doe","status":"1"}&fields=firstName,lastName,emailAddress&sort=-id,firstName&limit=10"
	 * @apiDescription Read data of all Users 
	 * @apiName    SearchUsers
	 * @apiGroup   Users
	 * 
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Users unique access-key.
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
	 * @apiParam   {String} [offset]                 Options offset specifies the maximum number of rows to return.
	 * @apiParam   {String} [count=1]                Optional count with default 1. Returns the count of users.
	 * 
	 * @apiSuccess {Number} id                       ID of the User.
	 * @apiSuccess {Number} groupId                  ID of the Group. 
	 * @apiSuccess {String} emailAddress             Email Address of the User.
	 * @apiSuccess {String} firstName                Firstname of the User.
	 * @apiSuccess {String} lastName                 Lastname of the User.
	 * @apiSuccess {String} password                 Password of the User.
	 * @apiSuccess {String} status                   Status of the User.
	 * @apiSuccess {String} active                   Flag of the User.
	 * @apiSuccess {String} created                  Creation date of the User.
	 * @apiSuccess {String} modified                 Modification date of the User.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "groupId": "56c4b6c2-1d54-11e4-b32d-eff91066cccf",
	 *       "emailAddress": "john.doe@moneymax.ph",
	 *       "firstName": "John",
	 *       "lastName": "Doe",
	 *       "status": 1,     
	 *       "active": "1", 
	 *       "created": "2014-07-11 09:13:27",
     *       "modified": "2014-07-11 09:52:08",
	 *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
	 *     },
	 *     {
	 *       "id": "c6bcb740-1dcc-11e4-b32d-eff91066cccf",
	 *       "groupId": "56c4b6c2-1d54-11e4-b32d-eff91066cccf",
	 *       "emailAddress": "mary@moneymax.ph",
	 *       "firstName": "Mary",
	 *       "lastName": "Doe",
	 *       "status": 1,      
	 *       "active": "1",
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
	 * @apiError RouteNotFound That route was not found on the server.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 
	 *     {
	 *       "error": "RouteNotFound"
	 *     } 
	 */
	public function search(){
		$user = new Users();
		return $this->respond($user);
	}
	
	/**
	 * @api {post} /admin/users/search/:id POST /users/search/:id
 	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i -X POST "http://apibeta.compargo.com/v1/admin/users/c6bcb740-1dcc-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 * @apiDescription Read data of a User
	 * @apiName SearchUser
	 * @apiGroup Users
	 * 
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Users unique access-key.
	 * 
	 * @apiParam   {String} language                 Mandatory Language.
	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {Number} id                       Mandatory Users unique ID.
	 * 
	 * @apiSuccess {Number} id                       ID of the User.
	 * @apiSuccess {Number} groupId                  ID of the Group. 
	 * @apiSuccess {String} emailAddress             Email Address of the User.
	 * @apiSuccess {String} firstName                Firstname of the User.
	 * @apiSuccess {String} lastName                 Lastname of the User.
	 * @apiSuccess {String} password                 Password of the User.
	 * @apiSuccess {String} status                   Status of the User.
	 * @apiSuccess {String} active                   Flag of the User.
	 * @apiSuccess {String} created                  Creation date of the User.
	 * @apiSuccess {String} modified                 Modification date of the User.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "groupId": "56c4b6c2-1d54-11e4-b32d-eff91066cccf",
	 *       "emailAddress": "john.doe@moneymax.ph",
	 *       "firstName": "John",
	 *       "lastName": "Doe",
	 *       "status": 1,
	 *       "active": 1,
	 *       "created": "2014-07-11 09:13:27",
	 *       "modified": "2014-07-11 09:52:08",
	 *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
	 *     }
	 *     
	 * @apiError UserNotFound The id of the User was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
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
		$request = $this->di->get('request');
		$parameters = $request->get();
	
		if (isset($parameters['query'])) {
			$user = new Users();
			$results = $this->respond($user, $id);
		}else{
			$results = Users::findFirstById($id);
		}
		return $results;
	}
	
	/**
	 * @api {post} /admin/users/login POST /users/login
	 * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/admin/users/login/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "emailAddress=steve@moneymax.ph&password=secret"
	 * @apiDescription Authenticates a User
	 * @apiName LoginUser
	 * @apiGroup Users
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Users unique access-key.
	 * 
	 * @apiParam   {String} language                 Mandatory Language.
	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} emailAddress             Mandatory Email Address of the User.
	 * @apiParam   {String} password	             Mandatory Password of the User.
	 *
	 * @apiSuccess {Number} id                       ID of the User.
	 * @apiSuccess {Number} groupId                  ID of the Group.
	 * @apiSuccess {String} emailAddress             Email Address of the User.
	 * @apiSuccess {String} firstName                Firstname of the User.
	 * @apiSuccess {String} lastName                 Lastname of the User.
	 * @apiSuccess {String} password                 Password of the User.
	 * @apiSuccess {String} status                   Status of the User.
	 * @apiSuccess {String} created                  Creation date of the User.
	 * @apiSuccess {String} modified                 Modification date of the User.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "groupId": "56c4b6c2-1d54-11e4-b32d-eff91066cccf",
	 *       "emailAddress": "john.doe@moneymax.ph",
	 *       "firstName": "John",
	 *       "lastName": "Doe",
	 *       "status": 1,
	 *       "active": 1,
	 *       "created": "2014-07-11 09:13:27",
	 *       "modified": "2014-07-11 09:52:08",
	 *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
	 *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
	 *     }
	 *
	 * @apiError BadInputParameter The request cannot be fulfilled due to bad syntax.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 400
	 *     {
	 *       "error": "BadInputParameter"
	 *     }
	 *     	 *     
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

	 * @apiError InvalidUsernamePassword The email address and/or password are invalid.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 422 Request unable to be followed due to semantic errors
	 *     {
	 *       "error": "InvalidUsernamePassword"
	 *     }
	 */
	public function login(){
		$request = $this->di->get('request');
		$emailAddress = $request->get('emailAddress');
		$password = $request->get('password');
		
		$user = new Users();
		$result = $user->authenticate($emailAddress, $password);
		if (!$result) {
			throw new HTTPException(
				"Request unable to be followed due to semantic errors",
				422,
				array(
					'dev' => 'Invalid username and/or password',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $result;
	}
}