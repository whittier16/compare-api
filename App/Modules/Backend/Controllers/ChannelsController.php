<?php
namespace App\Modules\Backend\Controllers;

use App\Modules\Backend\Models\Channels,
	App\Modules\Frontend\Models\Channels as ChannelsCollection,
	App\Common\Lib\Application\Controllers\RESTController,
	App\Common\Lib\Application\Exceptions\HTTPException;


class ChannelsController extends RESTController{

	/**
	 * Sets which fields may be searched against, and which fields are allowed to be returned in
	 * partial responses. 
	 * @var array
	 */
	protected $allowedFields = array(
		'search' => array(
				'id',
				'verticalId',
				'name', 
				'description', 
				'alias',
				'revenueValue',
				'perPage',
				'status',
				'active',
				'created',
				'modified',
				'createdBy',
				'modifiedBy'
		),
		'partials' => array(
				'id',
				'verticalId',
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
				'verticalId',
				'name', 
				'description', 
				'alias',
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
	protected $allowedObjects = array(
	);
	
	/**
	 * Channels constructor
	 */
	public function __construct(){
		parent::__construct(false, false);
		$this->parseRequest($this->allowedFields, $this->allowedObjects);
		$this->schemaDir = __DIR__ . $this->getDI()->getConfig()->application->jsonSchemaDir;
	}
	
	/**
	 * @api {get} /channels GET /channels
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/channels/?countryCode=ph&language=en&query={"status":"1"}&fields=id,verticalId,name,description,alias,language,revenueValue,perPage,status&sort=-id,verticalId,name&limit=10"
	 *
	 * @apiDescription Read data of all Channels
	 * @apiName        Get
	 * @apiGroup       Channels
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Channels unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of channels.
	 * 
	 * @apiSuccess     {String} id                       ID of the Channel. 
	 * @apiSuccess     {String} verticalId               Vertical ID of the Channel.
	 * @apiSuccess     {String} name                     Name of the Channel.
	 * @apiSuccess     {String} description              Description of the Channel.
	 * @apiSuccess     {String} alias                    Alias of the Channel.
	 * @apiSuccess     {String} revenueValue             Language of the Channel.
	 * @apiSuccess     {String} perPage                  Per Page of the Channel.
	 * @apiSuccess     {Number} status                   Status Flag of the Channel.
	 * @apiSuccess     {Number} active                   Active Flag of the Channel.
	 * @apiSuccess     {Date}   created                  Creation date of the Channel.
	 * @apiSuccess     {Date}   modified                 Modification date of the Channel.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Channel.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Channel.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "a1d14206-1ea9-11e4-b32d-eff91066cccf",
     *       "verticalId": "07f44e24-1d43-11e4-b32d-eff91066cccf",
     *       "name": "Credit Card",
     *       "description": "Credit Card",
     *       "alias": "credit-card",
     *       "revenueValue": "5.00",
     *       "perPage": "10",
     *       "columns": "[\"cashback\", \"airmiles\", \"points\", \"annualFee\"]",
     *       "badges": "[{\"label\": \"Octopus Card\", \"icon\": \"octo-card\"}, {\"label\": \"valid TaoBao\", \"icon\": \"taobao-card\"}]",
     *       "status": "1"
     *     },
     *     {
     *       "id": "dc7c34e2-1eae-11e4-b32d-eff91066cccf",
     *       "verticalId": "07f44e24-1d43-11e4-b32d-eff91066cccf",
     *       "name": "Home Loans",
     *       "description": "Home Loans",
     *       "alias": "home-loans",
     *       "revenueValue": "5.00",
     *       "perPage": "10",
     *       "status": "1"
     *     },
     *     {  
     *       "id": "a212fb3c-1eaf-11e4-b32d-eff91066cccf",
     *       "verticalId": "07f44e24-1d43-11e4-b32d-eff91066cccf",
     *       "name": "Personal Loan",
     *       "description": "Personal Loan",
     *       "alias": "personal-loan",
     *       "revenueValue": "5.00",
     *       "perPage": "10",
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
		$channel = new ChannelsCollection($this->di);
		return $this->respond($channel);
	}
	
	/**
	 * @api {get} /channels/:id GET /channels/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/channels/a1d14206-1ea9-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Channel
	 * @apiName        GetOne
	 * @apiGroup       Channels
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Channels unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Channel unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Channel.
	 * @apiSuccess     {String} verticalId               Vertical ID of the Channel.
	 * @apiSuccess     {String} name                     Name of the Channel.
	 * @apiSuccess     {String} description              Description of the Channel.
	 * @apiSuccess     {String} alias                    Alias of the Channel.
	 * @apiSuccess     {String} revenueValue             Revenue Value of the Channel.
	 * @apiSuccess     {String} perPage                  Per Page of the Channel.
	 * @apiSuccess     {Number} status                   Status of the Channel.
     * @apiSuccess     {Number} active                   Flag of the Channel.
	 * @apiSuccess     {Date}   created                  Creation date of the Channel.
	 * @apiSuccess     {Date}   modified                 Modification date of the Channel.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Channel.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Channel.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "c6b5edee-1eac-11e4-b32d-eff91066cccf",
     *       "verticalId": "78d7ca20-1dd0-11e4-b32d-eff91066cccf",
     *       "name": "Broadband",
     *       "description": "Broadband",
     *       "alias": "broadband",
     *       "revenueValue": "5.00",
     *       "perPage": "10",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-08 05:33:34",
     *       "modified": "0000-00-00 00:00:00",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     }
	 *
	 * @apiError ChannelNotFound The id of the Channel was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ChannelNotFound"
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
			$channel = new ChannelsCollection($this->di);
			$results = $this->respond($channel, $id);
		}else{
			$results = ChannelsCollection::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Channel does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * @api {post} /channels POST /channels
     * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/channels/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "verticalId=07f44e24-1d43-11e4-b32d-eff91066cccf&
	 *          name=Home%20Loans&
	 *          description=Home%20Loans&
	 *          revenueValue=5.00&
	 *          perPage=10&
	 *          status=1"
	 * 
	 * @apiDescription  Create a new Channel
	 * @apiName         Post
	 * @apiGroup        Channels
	 *
	 * @apiHeader       {String} X-COMPARE-REST-API-KEY   Channel unique access-key.
	 *
	 * @apiParam        {String} language                 Mandatory Language.
	 * @apiParam        {String} countryCode              Mandatory Country code.
	 * @apiParam        {String} verticalId               Mandatory Vertical ID of Channel.
	 * @apiParam        {String} name                     Mandatory Name of the Channel.
	 * @apiParam        {String} [description]            Optional Description of the Channel.
	 * @apiParam        {String} [alias]                  Optional Alias of the Channel.
	 * @apiParam        {String} [revenueValue]           Optional Revenue Value of the Channel.
	 * @apiParam        {String} [perPage]                Optional Per Page of the Channel.
	 * @apiParam        {String} [status=0]               Optional Status of the Channel.
	 * @apiParam        {String} [createdBy]              Optional ID of the User who created the Channel.
	 * @apiParam        {String} [modifiedBy]             Optional ID of the User who modified the Channel.
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
			$channel = new Channels();
			$data['id'] = $channel->id;
			$data['verticalId'] = isset($data['verticalId']) ? $data['verticalId'] : '';
			$data['name'] = isset($data['name']) ? $data['name'] : '';
			$data['description'] = isset($data['description']) ? $data['description'] : '';
			$data['alias'] = isset($data['alias']) ? $data['alias'] : '';
			$data['revenueValue'] = isset($data['revenueValue']) ? $data['revenueValue'] : '0.00';
			$data['perPage'] = isset($data['perPage']) ? $data['perPage'] : 0;

			// iterate each field on the json schemaj
			// and fill parameters to feed on validator later
			// required/mandatory fields w/o values will trigger a validation error
			$schemaFile = $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->channels;
			$output = readJsonFromFile($schemaFile, $this);
			if (!empty($output)) {
				$properties = $output['properties'];
				foreach ($properties as $key => $value) {
					if ( $key == 'options' ) continue;
					$params[$key] = !(empty($data[$key]))? $data[$key] : '';
				}
			}

			// $params['name'] = $data['name'];
			// $params['description'] = $data['description'];
			// $params['alias'] = $data['alias'];
			// $params['revenueValue'] = $data['revenueValue'];
			// $params['perPage'] = $data['perPage'];

			$valid = $channel->validateProperty($params, $schemaFile);
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
			
			$data['status'] = isset($data['status']) ? $data['status'] : 0;
			if (isset($data['status'])) {
				$data['active'] = ($data['status'] != Channels::ACTIVE) ? 0 : 1 ;
			}
			$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
			$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';
			
			if ($channel->create($data)){
				$results['id'] = $channel->id;
			} else {
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $channel->getMessages(),
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
	 * @api {delete} /channels/:id DELETE /channels/:id
	 * @apiExample Example usage:
	 * curl -i -X DELETE "http://apibeta.compargo.com/v1/channels/96b3d052-3716-11e4-b18a-fe7344fb1ea4	
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Delete a Channel
	 * @apiName        Delete
	 * @apiGroup       Channels
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Channels unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Channel Unique ID.
	 *
	 * @apiSuccess {String} id                       The ID of Channel.
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
	 * @apiError ChannelNotFound The id of the Channel was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ChannelNotFound"
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
		$channel = Channels::findFirstById($id);
		if (!$channel){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Channel does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		} else {
			if ($channel->delete() != false){
				$results['id'] = $channel->id;
			}else{
				
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $channel->getMessages(),
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
		}
		return $results;
	}
 	

	/**
	 * @api {put} /channels/:id PUT /channels/:id
	 * @apiExample Example usage:
	 * curl -i -X PUT "http://apibeta.compargo.com/v1/channels/96b3d052-3716-11e4-b18a-fe7344fb1ea4/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "name=PNB&link=http://www.pnb.com.ph&logo=ph/brands/10_pnb.gif"
	 *      
	 * @apiDescription Update a Channel
	 * @apiName  Put
	 * @apiGroup Channels
	 *
	 * @apiHeader {String} X-COMPARE-REST-API-KEY   Channels unique access-key.
	 *
	 * @apiParam  {String} language                 Mandatory Language.
	 * @apiParam  {String} countryCode              Mandatory Country Code.
	 * @apiParam  {String} id                       Mandatory Channel Unique ID.
	 * @apiParam  {String} verticalId               Mandatory Vertical ID of the Channel.
	 * @apiParam  {String} name                     Mandatory Name of the Channel.
	 * @apiParam  {String} [description]            Optional Description of the Channel.
	 * @apiParam  {String} [alias]                  Optional Alias of the Channel.
	 * @apiParam  {String} [revenueValue]           Optional Revenue Value of the Channel.
	 * @apiParam  {String} [perPage]                Optional Per Page of the Channel.
	 * @apiParam  {String} [status]                 Optional Status of the Channel.
	 * @apiParam  {String} [createdBy]              Optional ID of the User who created the Channel.
	 * @apiParam  {String} [modifiedBy]             Optional ID of the User who modified the Channel.
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
	 * @apiError ChannelNotFound The id of the Channel was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ChannelNotFound"
	 *     }
	 */
	public function put($id){
		$results = $params = array();
		$request = $this->di->get('request');
		$data = $request->getPut();
		if (!empty($data)) {
			$channel = Channels::findFirstById($id);
			if (!$channel){
				throw new HTTPException(
					"Not found",
					404,
					array(
						'dev' => 'Channel does not exist',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			} else {
				$data['verticalId'] = isset($data['verticalId']) ? $data['verticalId'] : $channel->verticalId;
				$data['name'] = isset($data['name']) ? $data['name'] : $channel->name;
				$data['description'] = isset($data['description']) ? $data['description'] : $channel->description;
				$data['alias'] = isset($data['alias']) ? $data['alias'] : '';
				$data['revenueValue'] = isset($data['revenueValue']) ? $data['revenueValue'] : $channel->revenueValue;
				$data['perPage'] = isset($data['perPage']) ? $data['perPage'] : $channel->perPage;
				$data['status'] = isset($data['status']) ? $data['status'] : $channel->status;
				if (isset($data['status'])) {
					$data['active'] = ($data['status'] != Channels::ACTIVE) ? 0 : 1 ;
				}
				$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : $channel->createdBy;
				$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : $channel->modifiedBy;

				$params['name'] = $data['name'];
				$params['description'] = $data['description'];
				$params['alias'] = $data['alias'];
				$params['revenueValue'] = $data['revenueValue'];
				$params['perPage'] = $data['perPage'];
				
				$valid = $channel->validateProperty($params, $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->channels);
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
				
				if ($channel->save($data)){
					$results['id'] = $channel->id;
				} else {
					throw new HTTPException(
						"Request unable to be followed due to semantic errors",
						422,
						array(
							'dev' => $channel->getMessages(),
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
	 * @api {post} /channels/search POST /channels/search
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/channels/search/?countryCode=ph&language=en"
	 *      -d "query={"status":"1"}&fields=id,verticalId,name,description,alias,language,revenueValue,perPage,status&sort=-id,verticalId,name&limit=10"
	 *
	 * @apiDescription Read data of all Channels
	 * @apiName        Search
	 * @apiGroup       Channels
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Channels unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of channels.
	 * 
	 * @apiSuccess     {String} id                       ID of the Channel. 
	 * @apiSuccess     {String} verticalId               Vertical ID of the Channel.
	 * @apiSuccess     {String} name                     Name of the Channel.
	 * @apiSuccess     {String} description              Description of the Channel.
	 * @apiSuccess     {String} alias                    Alias of the Channel.
	 * @apiSuccess     {String} revenueValue             Language of the Channel.
	 * @apiSuccess     {String} perPage                  Per Page of the Channel.
	 * @apiSuccess     {Number} status                   Status Flag of the Channel.
	 * @apiSuccess     {Number} active                   Active Flag of the Channel.
	 * @apiSuccess     {Date}   created                  Creation date of the Channel.
	 * @apiSuccess     {Date}   modified                 Modification date of the Channel.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Channel.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Channel.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "a1d14206-1ea9-11e4-b32d-eff91066cccf",
     *       "verticalId": "07f44e24-1d43-11e4-b32d-eff91066cccf",
     *       "name": "Credit Card",
     *       "description": "Credit Card",
     *       "alias": "credit-card",
     *       "revenueValue": "5.00",
     *       "perPage": "10",
     *       "status": "1"
     *     },
     *     {
     *       "id": "dc7c34e2-1eae-11e4-b32d-eff91066cccf",
     *       "verticalId": "07f44e24-1d43-11e4-b32d-eff91066cccf",
     *       "name": "Home Loans",
     *       "description": "Home Loans",
     *       "alias": "home-loans",
     *       "revenueValue": "5.00",
     *       "perPage": "10",
     *       "status": "1"
     *     },
     *     {  
     *       "id": "a212fb3c-1eaf-11e4-b32d-eff91066cccf",
     *       "verticalId": "07f44e24-1d43-11e4-b32d-eff91066cccf",
     *       "name": "Personal Loan",
     *       "description": "Personal Loan",
     *       "alias": "personal-loan",
     *       "revenueValue": "5.00",
     *       "perPage": "10",
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
		$channel = new ChannelsCollection($this->di);
		return $this->respond($channel);
	}
	
	/**
	 * @api {post} /channels/search/:id POST /channels/search/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/channels/search/a1d14206-1ea9-11e4-b32d-eff91066cccf/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Channel
	 * @apiName        SearchOne
	 * @apiGroup       Channels
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Channels unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Channel unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Channel.
	 * @apiSuccess     {String} verticalId               Vertical ID of the Channel.
	 * @apiSuccess     {String} name                     Name of the Channel.
	 * @apiSuccess     {String} description              Description of the Channel.
	 * @apiSuccess     {String} alias                    Alias of the Channel.
	 * @apiSuccess     {String} revenueValue             Revenue Value of the Channel.
	 * @apiSuccess     {String} perPage                  Per Page of the Channel.
	 * @apiSuccess     {Number} status                   Status of the Channel.
     * @apiSuccess     {Number} active                   Flag of the Channel.
	 * @apiSuccess     {Date}   created                  Creation date of the Channel.
	 * @apiSuccess     {Date}   modified                 Modification date of the Channel.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Channel.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Channel.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "c6b5edee-1eac-11e4-b32d-eff91066cccf",
     *       "verticalId": "78d7ca20-1dd0-11e4-b32d-eff91066cccf",
     *       "name": "Broadband",
     *       "description": "Broadband",
     *       "alias": "broadband",
     *       "revenueValue": "5.00",
     *       "perPage": "10",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-08 05:33:34",
     *       "modified": "0000-00-00 00:00:00",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     }
	 *
	 * @apiError ChannelNotFound The id of the Channel was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ChannelNotFound"
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
			$channel = new ChannelsCollection($this->di);
			$results = $this->respond($channel, $id);
		}else{
			$results = ChannelsCollection::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Channel does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
}