<?php
namespace App\Modules\Backend\Controllers;

use App\Modules\Backend\Models\ChannelsOptions,
	App\Modules\Frontend\Models\ChannelsOptions as ChannelsOptionsCollection,
	App\Common\Lib\Application\Controllers\RESTController,
	App\Common\Lib\Application\Exceptions\HTTPException;


class ChannelsOptionsController extends RESTController{

	/**
	 * Sets which fields may be searched against, and which fields are allowed to be returned in
	 * partial responses. 
	 * @var array
	 */
	protected $allowedFields = array(
		'search' => array(
				'id',
				'channelId',
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
				'channelId',
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
				'channelId',
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
	 * Channels constructor
	 */
	public function __construct(){
		parent::__construct(false, false);
		$this->parseRequest($this->allowedFields, $this->allowedObjects);
	}
	
	/**
	 * @api {get} /channels_options GET /channels_options
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/channels_options/?countryCode=ph&language=en&
	 *          query={"status":"1"}&fields=id,verticalId,name,description,alias,language,revenueValue,perPage,status&
	 *          sort=-id,verticalId,name&
	 *          limit=10"
	 *
	 * @apiDescription Read data of all Channels Options
	 * @apiName        Get
	 * @apiGroup       Channels Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Channels Options unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of channels options.
	 * 
	 * @apiSuccess     {String} id                       ID of the Channels Options. 
	 * @apiSuccess     {String} channelId                Channel ID of the Channels Options. 
	 * @apiSuccess     {String} name                     Name of the Channels Options. 
	 * @apiSuccess     {String} value                    Value of the Channels Options. 
	 * @apiSuccess     {String} label                    Label of the Channels Options.
	 * @apiSuccess     {String} editable                 Editable Flag of the Channels Options. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Channels Options.  
	 * @apiSuccess     {Number} status                   Status Flag of the Channels Options. 
	 * @apiSuccess     {Number} active                   Active Flag of the Channels Options. 
	 * @apiSuccess     {Date}   created                  Creation date of the Channels Options. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Channels Options. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Channels Options. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Channels Options. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "f8a145d4-20fe-11e4-b94f-085fc4b84f62",
     *       "channelId": "a1d14206-1ea9-11e4-b32d-eff91066cccf",
     *       "name": "columns",
     *       "value": "[\"cashback\", \"airmiles\", \"points\", \"annualFee\"]",
     *       "label": "",
     *       "editable": "1",
     *       "visibility": "1",
     *       "status": "1"
     *     },
	 *     {
	 *       "id": "05a5ec26-372a-11e4-b18a-fe7344fb1ea4",
     *       "channelId": "a1d14206-1ea9-11e4-b32d-eff91066cccf",
     *       "name": "badges",
     *       "value": "[{\"label\": \"Octopus Card\", \"icon\": \"octo-card\"}, {\"label\": \"valid TaoBao\", \"icon\": \"taobao-card\"}]",
     *       "label": "",
     *       "editable": "1",
     *       "visibility": "1",
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
		$channelsOptions = new ChannelsOptionsCollection($this->di);
		return $this->respond($channelsOptions);
	}
	
	/**
	 * @api {get} /channels_options/:id GET /channels_options/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/channels_options/05a5ec26-372a-11e4-b18a-fe7344fb1ea4/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Channel Options
	 * @apiName        GetOne
	 * @apiGroup       Channels Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Channels Options unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Channel Options unique ID.
	 *
 	 * @apiSuccess     {String} id                       ID of the Channels Option.
	 * @apiSuccess     {String} channelId                Channel ID of the Channels Option.
	 * @apiSuccess     {String} name                     Name of the Channels Option.
	 * @apiSuccess     {String} value                    Value of the Channels Option.
	 * @apiSuccess     {String} label                    Label of the Channels Option.
	 * @apiSuccess     {String} editable                 Editable Flag of the Channels Option. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Channels Option.  
	 * @apiSuccess     {Number} status                   Status Flag of the Channels Option. 
	 * @apiSuccess     {Number} active                   Active Flag of the Channels Option. 
	 * @apiSuccess     {Date}   created                  Creation date of the Channels Option. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Channels Option. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Channels Option. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Channels Option. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "f8a145d4-20fe-11e4-b94f-085fc4b84f62",
     *       "channelId": "a1d14206-1ea9-11e4-b32d-eff91066cccf",
     *       "name": "columns",
     *       "value": "[\"cashback\", \"airmiles\", \"points\", \"annualFee\"]",
     *       "label": "",
     *       "editable": "1",
     *       "visibility": "1",
     *       "status": "1"
     *     }
	 *
	 * @apiError ChannelsOptionNotFound The id of the Channels Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ChannelsOptionNotFound"
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
			$channelsOptions = new ChannelsOptionsCollection($this->di);
			$results = $this->respond($channelsOptions, $id);
		}else{
			$results = ChannelsOptionsCollection::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Channels option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * @api {post} /channels_options POST /channels_options
     * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/channels_options/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "channelId=a1d14206-1ea9-11e4-b32d-eff91066cccf&
	 *          name=keyInfo&
	 *          value={\"greatFor\":{\"columns\":[\"greatFor1\",\"greatFor2\"],\"limit\":\"2\"},\"bewareThat\":{\"columns\":[\"bewareThat1\"],\"limit\":"1"}}&
	 *          status=1"
	 * 
	 * @apiDescription  Create a new Channels Options
	 * @apiName         Post
	 * @apiGroup        Channels Options
	 *
	 * @apiHeader       {String} X-COMPARE-REST-API-KEY   Channels Options unique access-key.
	 *
	 * @apiParam        {String} language                 Mandatory Language.
	 * @apiParam        {String} countryCode              Mandatory Country code.
	 * @apiParam        {String} channelId                Mandatory Vertical ID of Channels Options.
	 * @apiParam        {String} name                     Mandatory Name of the Channels Options.
	 * @apiParam        {String} value                    Mandatory Value of the Channels Options.
	 * @apiParam        {String} [label]                  Optional Label of the Channels Options.
	 * @apiParam        {String} [editable=0]             Optional Editable Flag of the Channels Options.
	 * @apiParam        {String} [visibility=0]           Optional Revenue Value of the Channels Options.
	 * @apiParam        {String} [status=0]               Optional Status of the Channels Options.
	 * @apiParam        {String} [createdBy]              Optional ID of the User who created the Channels Options.
	 * @apiParam        {String} [modifiedBy]             Optional ID of the User who modified the Channels Options.
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
			$channelsOptions = new ChannelsOptions();
			$data['id'] = $channelsOptions->id;
			$data['channelId'] = isset($data['channelId']) ? $data['channelId'] : '';
			$data['name'] = isset($data['name']) ? $data['name'] : '';
			$data['value'] = isset($data['value']) ? $data['value'] : '';
			$data['label'] = isset($data['label']) ? $data['label'] : '';
			$data['status'] = isset($data['status']) ? $data['status'] : 0;
			if (isset($data['status'])) {
				$data['active'] = ($data['status'] != ChannelsOptions::ACTIVE) ? 0 : 1 ;
				$data['editable'] = ($data['status'] != ChannelsOptions::ACTIVE) ? 0 : $data['editable'];
				$data['visibility'] = ($data['status'] != ChannelsOptions::ACTIVE) ? 0 : $data['visibility'];
			}
			$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
			$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';
			
			$params[$data['name']] = $data['value'];
			$params['description'] = $data['description'];
			$params['alias'] = $data['alias'];
			$params['revenueValue'] = $data['revenueValue'];
			$params['perPage'] = $data['perPage'];
			$valid = $channel->validateProperty($params, $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->channels);
			if ($channelsOptions->save($data)){
				$results['id'] = $channelsOptions->id;
			} else {
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $channelsOptions->getMessages(),
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
	 * @api {delete} /channels_options/:id DELETE /channels_options/:id
	 * @apiExample Example usage:
	 * curl -i -X DELETE "http://apibeta.compargo.com/v1/channels_options/96b3d052-3716-11e4-b18a-fe7344fb1ea4	
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Delete a Channels Option
	 * @apiName        Delete
	 * @apiGroup       Channels Options
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Channels Options unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Channels Option Unique ID.
	 *
	 * @apiSuccess {String} id                       The ID of Channels Option.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "f8a145d4-20fe-11e4-b94f-085fc4b84f62"
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
	 * @apiError ChannelsOptionNotFound The id of the Channels Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ChannelsOptionNotFound"
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
		$channelsOptions = ChannelsOptions::findFirstById($id);
		if (!$channelsOptions){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Channel option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		} else {
			if ($channelsOptions->delete()){
				$results['id'] = $channelsOptions->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $channelsOptions->getMessages(),
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
		}
		return $results;
	}
 	
	/**
	 * @api {put} /channels_options/:id PUT /channels_options/:id
	 * @apiExample Example usage:
	 * curl -i -X PUT "http://apibeta.compargo.com/v1/channels_options/f8a145d4-20fe-11e4-b94f-085fc4b84f62/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "channelId=f8a145d4-20fe-11e4-b94f-085fc4b84f62&
	 *          value=[\"cashback\", \"airmiles\", \"points\"]&
	 *          editable=0&
	 *          visibility=0&
	 *          status=1"
	 *      
	 * @apiDescription Update a Channels Option
	 * @apiName  Put
	 * @apiGroup Channels Options
	 *
	 * @apiHeader {String} X-COMPARE-REST-API-KEY   Channels Options unique access-key.
	 *
	 * @apiParam  {String} language                 Mandatory Language.
	 * @apiParam  {String} countryCode              Mandatory Country Code.
	 * @apiParam  {String} id                       Mandatory Channels Option Unique ID.
	 * @apiParam  {String} channelId                Mandatory Channel ID of the Channels Option.
	 * @apiParam  {String} name                     Mandatory Name of the Channels Option.
	 * @apiParam  {String} value                    Mandatory Value of the Channels Option.
	 * @apiParam  {String} [label]                  Optional Label of the Channels Option.
	 * @apiParam  {String} [editable]               Optional Editable Flag of the Channels Option.
	 * @apiParam  {String} [visibility]             Optional Visibility Flag of the Channels Option.
	 * @apiParam  {String} [status]                 Optional Status of the Channels Option.
	 * @apiParam  {String} [createdBy]              Optional ID of the User who created the Channels Option.
	 * @apiParam  {String} [modifiedBy]             Optional ID of the User who modified the Channels Option.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "f8a145d4-20fe-11e4-b94f-085fc4b84f62"
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
	 * @apiError ChannelsOptionsNotFound The id of the Channels Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ChannelsOptionNotFound"
	 *     }
	 */
	public function put($id){
		$results = $params = array();
		$request = $this->di->get('request');
		$data = $request->getPut();
		
		if (!empty($data)){
			$channelsOptions = ChannelsOptions::findFirstById($id);
			if (!$channelsOptions){
				throw new HTTPException(
					"Not found",
					404,
					array(
						'dev' => 'Channel option does not exist',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			} else {
				$data['channelId'] = isset($data['channelId']) ? $data['channelId'] : $channelsOptions->channelId;
				$data['name'] = isset($data['name']) ? $data['name'] : $channelsOptions->name;
				$data['value'] = isset($data['value']) ? $data['value'] : $channelsOptions->value;
				$data['label'] = isset($data['label']) ? $data['label'] : $channelsOptions->label;
				$data['status'] = isset($data['status']) ? $data['status'] : $channelsOptions->status;
				if (isset($data['status'])) {
					$data['active'] = ($data['status'] != ChannelsOptions::ACTIVE) ? 0 : 1 ;
					$data['editable'] = ($data['status'] != ChannelsOptions::ACTIVE) ? 0 : $channelsOptions->editable;
					$data['visibility'] = ($data['status'] != ChannelsOptions::ACTIVE) ? 0 : $channelsOptions->visibility;
				} 
				$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : $channelsOptions->createdBy;
				$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : $channelsOptions->modifiedBy;
				
				if ($channelsOptions->save($data)){
					$results['id'] = $channelsOptions->id;
				}else{
					throw new HTTPException(
						"Request unable to be followed due to semantic errors",
						422,
						array(
							'dev' => $channelsOptions->getMessages(),
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
	 * @api {post} /channels_options/search POST /channels_options/search
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/channels_options/search/?countryCode=ph&language=en&
	 *      -d "query={"status":"1"}&fields=id,verticalId,name,description,alias,language,revenueValue,perPage,status&
	 *          sort=-id,verticalId,name&
	 *          limit=10"
	 *
	 * @apiDescription Read data of all Channels Options
	 * @apiName        Post
	 * @apiGroup       Channels Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Channels Options unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of channels options.
	 * 
	 * @apiSuccess     {String} id                       ID of the Channels Options. 
	 * @apiSuccess     {String} channelId                Channel ID of the Channels Options. 
	 * @apiSuccess     {String} name                     Name of the Channels Options. 
	 * @apiSuccess     {String} value                    Value of the Channels Options. 
	 * @apiSuccess     {String} label                    Label of the Channels Options.
	 * @apiSuccess     {String} editable                 Editable Flag of the Channels Options. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Channels Options.  
	 * @apiSuccess     {Number} status                   Status Flag of the Channels Options. 
	 * @apiSuccess     {Number} active                   Active Flag of the Channels Options. 
	 * @apiSuccess     {Date}   created                  Creation date of the Channels Options. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Channels Options. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Channels Options. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Channels Options. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "f8a145d4-20fe-11e4-b94f-085fc4b84f62",
     *       "channelId": "a1d14206-1ea9-11e4-b32d-eff91066cccf",
     *       "name": "columns",
     *       "value": "[\"cashback\", \"airmiles\", \"points\", \"annualFee\"]",
     *       "label": "",
     *       "editable": "1",
     *       "visibility": "1",
     *       "status": "1"
     *     },
	 *     {
	 *       "id": "05a5ec26-372a-11e4-b18a-fe7344fb1ea4",
     *       "channelId": "a1d14206-1ea9-11e4-b32d-eff91066cccf",
     *       "name": "badges",
     *       "value": "[{\"label\": \"Octopus Card\", \"icon\": \"octo-card\"}, {\"label\": \"valid TaoBao\", \"icon\": \"taobao-card\"}]",
     *       "label": "",
     *       "editable": "1",
     *       "visibility": "1",
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
		$channelsOptions = new ChannelsOptionsCollection($this->di);
		return $this->respond($channelsOptions);
	}
	
	/**
	 * @api {post} /channels_options/search/:id POST /channels_options/search/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/channels_options/search/05a5ec26-372a-11e4-b18a-fe7344fb1ea4/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Channel Options
	 * @apiName        SearchOne
	 * @apiGroup       Channels Options
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Channels Options unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Channel Options unique ID.
	 *
 	 * @apiSuccess     {String} id                       ID of the Channels Option.
	 * @apiSuccess     {String} channelId                Channel ID of the Channels Option.
	 * @apiSuccess     {String} name                     Name of the Channels Option.
	 * @apiSuccess     {String} value                    Value of the Channels Option.
	 * @apiSuccess     {String} label                    Label of the Channels Option.
	 * @apiSuccess     {String} editable                 Editable Flag of the Channels Option. 
	 * @apiSuccess     {String} visibility               Visibility Flag of the Channels Option.  
	 * @apiSuccess     {Number} status                   Status Flag of the Channels Option. 
	 * @apiSuccess     {Number} active                   Active Flag of the Channels Option. 
	 * @apiSuccess     {Date}   created                  Creation date of the Channels Option. 
	 * @apiSuccess     {Date}   modified                 Modification date of the Channels Option. 
	 * @apiSuccess     {String} createdBy                ID of the User who created the Channels Option. 
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Channels Option. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "f8a145d4-20fe-11e4-b94f-085fc4b84f62",
     *       "channelId": "a1d14206-1ea9-11e4-b32d-eff91066cccf",
     *       "name": "columns",
     *       "value": "[\"cashback\", \"airmiles\", \"points\", \"annualFee\"]",
     *       "label": "",
     *       "editable": "1",
     *       "visibility": "1",
     *       "status": "1"
     *     }
	 *
	 * @apiError ChannelsOptionNotFound The id of the Channels Option was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ChannelsOptionsNotFound"
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
			$channelsOptions = new ChannelsOptionsCollection($this->di);
			$results = $this->respond($channelsOptions, $id);
		}else{
			$results = ChannelsOptionsCollection::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Channels option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
