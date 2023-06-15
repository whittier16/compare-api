<?php
namespace App\Modules\Backend\Controllers;

use Phalcon\Mvc\Model\MetaData\Memory,
	App\Modules\Backend\Models\Products as Products,
	App\Modules\Backend\Models\ProductsOptions,
	App\Modules\Backend\Models\Brands,
	App\Modules\Backend\Models\Companies,
	App\Modules\Backend\Models\Areas,
	App\Modules\Frontend\Models\Products as ProductsCollection,
	App\Common\Lib\Application\Libraries\ImageUpload,
	App\Common\Lib\Application\Controllers\RESTController,
    App\Common\Lib\Application\Exceptions\HTTPException;
use App\Modules\Backend\Models\Channels;

class ProductsController extends RESTController{

	/**
	 * Sets which fields may be searched against, and which fields are allowed to be returned in
	 * partial responses. 
	 * @var array
	 */
	protected $allowedFields = array(
		'search' => array(
			'id',
			'channelId',
			'brandId',
			'name', 
			'description',
			'alias',	 
			'featured',
			'icon',
			'langauge',
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
			'brandId',	
			'name',
			'description',
			'alias',
			'featured',
			'icon',
			'langauge',
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
			'brandId',
			'name', 
			'description',
			'alias',
			'featured',
			'icon',
			'langauge',
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
		'channels',
		'brands'	
	);
	
	protected $columns = "id,channel_id,brand_id,name,alias,description,featured,icon,language";
	
	protected $schemaDir;
	
	/**
	 * Product constructor
	 */ 
	public function __construct(){
		parent::__construct(false);
		$this->parseRequest($this->allowedFields, $this->allowedObjects);
		$this->schemaDir = __DIR__ . $this->getDI()->getConfig()->application->jsonSchemaDir;
	}
	
	/**
	 * @api {get} /products GET /products
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/products/?countryCode=ph&language=en&query={"status":"1"}&fields=id,channelId,brandId,name,alias,description,featured,icon,language&sort=id,channelId,brandId&limit=10"
	 *
	 * @apiDescription Read data of all Products
	 * @apiName        Get
	 * @apiGroup       Products
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Product unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of products.
	 * 
	 * @apiSuccess     {String} id                       ID of the Product. 
	 * @apiSuccess     {String} channelId                Channel ID of the Product.
	 * @apiSuccess     {String} brandId                  Brand ID of the Product.
	 * @apiSuccess     {String} name                     Name of the Product.
	 * @apiSuccess     {String} description              Description of the Product.
	 * @apiSuccess     {String} alias                    Alias of the Product.
	 * @apiSuccess     {String} featured                 Featured Flag of the Product.
	 * @apiSuccess     {String} icon                     Icon of the Product.
	 * @apiSuccess     {String} language                 Language of the Product.
	 * @apiSuccess     {Number} status                   Status Flag of the Product.
	 * @apiSuccess     {Number} active                   Active Flag of the Product.
	 * @apiSuccess     {Date}   created                  Creation date of the Product.
	 * @apiSuccess     {Date}   modified                 Modification date of the Product.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Product.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Product.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *	   {
     *       "id": "8c17dab6-2e8e-11e4-988c-7d9574853fac",
     *       "channelId": "a1d14206-1ea9-11e4-b32d-eff91066cccf",
     *       "brandId": "bc75db6e-2dde-11e4-988c-7d9574853fac",
     *       "name": "Visa Classic",
     *       "description": null,
     *       "alias": "visa-classic",
     *       "featured": "0",
     *       "icon": null,
     *       "language": "en",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-28 10:37:29",
     *       "modified": "0000-00-00 00:00:00",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *   },
     *   {
     *       "id": "b4b42cb2-32fe-11e4-8ce3-5bbea8105782",
     *       "channelId": "a1d14206-1ea9-11e4-b32d-eff91066cccf",
     *       "brandId": "1c28fefa-319b-11e4-988c-7d9574853fac",
     *       "name": "Visa Gold",
     *       "description": null,
     *       "alias": "visa-gold",
     *       "featured": "0",
     *       "icon": null,
     *       "language": "en",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-09-03 02:10:26",
     *       "modified": "0000-00-00 00:00:00",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
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
		$product = new ProductsCollection($this->di);
		return $this->respond($product);
	}

	/**
	 * @api {get} /products/:id GET /products/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/products/e8f2a77f-3a19-11e4-96e3-06f157c98b98/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Product
	 * @apiName        GetOne
	 * @apiGroup       Products
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Channels unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Channel unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Product.
	 * @apiSuccess     {String} channelId                Vertical ID of the Product.
	 * @apiSuccess     {String} brandId                  Brand ID of the Product.
	 * @apiSuccess     {String} name                     Name of the Product.
	 * @apiSuccess     {String} description              Description of the Product.
	 * @apiSuccess     {String} alias                    Alias of the Product.
	 * @apiSuccess     {String} featured                 Featured Flag of the Product.
	 * @apiSuccess     {String} icon                     Icon of the Product.
	 * @apiSuccess     {String} language                 Language of the Product.
	 * @apiSuccess     {Number} status                   Status of the Product.
     * @apiSuccess     {Number} active                   Flag of the Product.
	 * @apiSuccess     {Date}   created                  Creation date of the Product.
	 * @apiSuccess     {Date}   modified                 Modification date of the Product.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Product.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Product.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "e8f2a77f-3a19-11e4-96e3-06f157c98b98",
     *       "channelId": "83e63b14-3a15-11e4-96e3-06f157c98b98",
     *       "brandId": "3a1a5074-3a19-11e4-96e3-06f157c98b98",
     *       "name": "Petron-BPI MasterCard",
     *       "description": "Petron-BPI MasterCard",
     *       "alias": "petron-bpi-mastercard",
     *       "featured": "0",
     *       "icon": "0",
     *       "language": "en",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-09-12 01:12:48",
     *       "modified": "0000-00-00 00:00:00",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     }
	 *
	 * @apiError ProductNotFound The id of the Product was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ProductNotFound"
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
			$product = new ProductsCollection($this->di);
			$results = $this->respond($product, $id);
		}else{
			$results = ProductsCollection::find(array(array('id' => $id)));
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Product does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * @api {post} /products POST /products
     * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/products/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "channelId=a1d14206-1ea9-11e4-b32d-eff91066cccf&
	 *          brandId=1c28fefa-319b-11e4-988c-7d9574853fac&
	 *          name=Visa%20Gold&
	 *          featured=0&
	 *          status=1"
	 * 
	 * @apiDescription  Create a new Product
	 * @apiName         Post
	 * @apiGroup        Products
	 *
	 * @apiHeader       {String} X-COMPARE-REST-API-KEY   Product unique access-key.
	 *
	 * @apiParam        {String} language                 Mandatory Language.
	 * @apiParam        {String} countryCode              Mandatory Country code.
	 * @apiParam        {String} channelId                Mandatory Channel ID of Product.
	 * @apiParam        {String} brandId                  Mandatory Brand ID of Product.
	 * @apiParam        {String} name                     Mandatory Name of the Product.
	 * @apiParam        {String} [description]            Optional Description of the Product.
	 * @apiParam        {String} [alias]                  Optional Alias of the Product.
	 * @apiParam        {String} [feaured=0]              Optional Featured Value of the Product.
	 * @apiParam        {String} [icon=0]                 Optional Icon of the Product.
	 * @apiParam        {String} [perPage]                Optional Per Page of the Product.
	 * @apiParam        {String} [status=0]               Optional Status of the Product.
	 * @apiParam        {String} [createdBy]              Optional ID of the User who created the Product.
	 * @apiParam        {String} [modifiedBy]             Optional ID of the User who modified the Product.
	 *	
	 * @apiSuccess      {String} id                       The new Product-ID.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "f77cf470-3bdc-11e4-b18a-fe7344fb1ea4"
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
			$product = new Products();
			$data['id'] = $product->id;
			$data['channelId'] = isset($data['channelId']) ? $data['channelId'] : '';
			$data['brandId'] = isset($data['brandId']) ? $data['brandId'] : '';
			$data['name'] = isset($data['name']) ? $data['name'] : '';
			$data['alias'] = isset($data['alias']) ? $data['alias'] : '';
			$data['description'] = isset($data['description']) ? $data['description'] : '';
			$data['featured'] = isset($data['featured']) ? $data['featured'] : '';
			$data['icon'] = isset($data['featured']) ? $data['featured'] : '';
			$data['language'] = isset($data['language']) ? $data['language'] : '';
			$data['status'] = isset($data['status']) ? $data['status'] : '';
			if (isset($data['status'])) {
				$data['active'] = ($data['status'] != Products::ACTIVE) ? 0 : 1 ;
			}
			$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
			$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';
			
			if ($product->save($data)){
				$results['id'] = $product->id;
			}else{
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $product->getMessages(),
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
	 * @api {delete} /products/:id DELETE /products/:id
	 * @apiExample Example usage:
	 * curl -i -X DELETE "http://apibeta.compargo.com/v1/products/96b3d052-3716-11e4-b18a-fe7344fb1ea4	
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Delete a Product
	 * @apiName        Delete
	 * @apiGroup       Products
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Products unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Product Unique ID.
	 *
	 * @apiSuccess {String} id                       The ID of Product.
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
	 * @apiError ProductNotFound The id of the Product was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ProductNotFound"
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
		$product = Products::findFirstById($id);
		if ($product){
			if (Products::DISABLED == $product->status) {
				throw new HTTPException(
					"Not found",
					404,
					array(
						'dev' => 'The requested product does not exist',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			} else {
				if ($product->delete()){
					$results['id'] = $id;
				}else{
					throw new HTTPException(
						"Request unable to be followed due to semantic errors",
						422,
						array(
							'dev' => $product->getMessages(),
							'internalCode' => 'P1000',
							'more' => '' // Could have link to documentation here.
						)
					);
				}
			}
		} else {
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'The requested product does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
 
	/**
	 * @api {put} /products/:id PUT /products/:id
	 * @apiExample Example usage:
	 * curl -i -X PUT "http://apibeta.compargo.com/v1/products/b4b42cb2-32fe-11e4-8ce3-5bbea8105782/?countryCode=ph&language=en"
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "channelId=a1d14206-1ea9-11e4-b32d-eff91066cccf&
	 *          brandId=10ab7190-38bf-11e4-b18a-fe7344fb1ea4&
	 *          name=Petron-BPI MasterCard&
	 *          featured=1
	 *      
	 * @apiDescription Update a Product
	 * @apiName  Put
	 * @apiGroup Products
	 *
	 * @apiHeader {String} X-COMPARE-REST-API-KEY   Products unique access-key.
	 *
	 * @apiParam  {String} language                 Mandatory Language.
	 * @apiParam  {String} countryCode              Mandatory Country Code.
	 * @apiParam  {String} id                       Mandatory Product Unique ID.
	 * @apiParam  {String} channelId                Mandatory Channel ID of the Product.
	 * @apiParam  {String} brandId                  Mandatory Brand ID of the Product.
	 * @apiParam  {String} name                     Mandatory Name of the Product.
	 * @apiParam  {String} [description]            Optional Description of the Product.
	 * @apiParam  {String} [alias]                  Optional Alias of the Product.
	 * @apiParam  {String} [featured=0]             Optional Featured Flag of the Product.
	 * @apiParam  {String} [icon]                   Optional Icon of the Product.
	 * @apiParam  {String} [status=0]               Optional Status of the Product.
	 * @apiParam  {String} [createdBy]              Optional ID of the User who created the Product.
	 * @apiParam  {String} [modifiedBy]             Optional ID of the User who modified the Product.
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
	 * @apiError ProductNotFound The id of the Product was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ProductlNotFound"
	 *     }
	 */
	public function put($id){
		$results = array();
		$request = $this->di->get('request');
		$data = $request->getPut();
		
		if (!empty($data)){
			$product = Products::findFirstById($id);
			if (!$product) {
				throw new HTTPException(
					"Not found",
					404,
					array(
						'dev' => 'The requested product does not exist',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			} else {
				$data['channelId'] = isset($data['channelId']) ? $data['channelId'] : $product->channelId;
				$data['brandId'] = isset($data['brandId']) ? $data['brandId'] : $product->brandId;
				$data['name'] = isset($data['name']) ? $data['name'] : $product->name;
				$data['description'] = isset($data['description']) ? $data['description'] : $product->description;
				$data['featured'] = isset($data['featured']) ? $data['featured'] : $product->featured;
				$data['icon'] = isset($data['icon']) ? $data['icon'] : $product->icon;
				$data['language'] = isset($data['language']) ? $data['language'] : $product->language;
				$data['status'] = isset($data['status']) ? $data['status'] : $product->status;
				if (isset($data['status'])) {
					$data['active'] = ($data['status'] != Products::ACTIVE) ? 0 : 1 ;
				}
				$data['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : '';
				$data['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : '';
				if ($product->save($data)){
					$results['id'] = $product->id;
				}else{
					throw new HTTPException(
						"Request unable to be followed due to semantic errors",
						422,
						array(
							'dev' => $product->getMessages(),
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
	 * @api {post} /products/search POST /products/search
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i -X POST "http://apibeta.compargo.com/v1/products/search/?countryCode=ph&language=en
	 *      -d "query={"status":"1"}&fields=id,channelId,brandId,name,alias,description,featured,icon,language&
	 *          sort=id,channelId,brandId&
	 *          limit=10"
	 *
	 * @apiDescription Read data of all Products
	 * @apiName        Search
	 * @apiGroup       Products
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Product unique access-key.
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
	 * @apiParam       {String} [count=1]                Optional count with default 1. Returns the count of products.
	 * 
	 * @apiSuccess     {String} id                       ID of the Product. 
	 * @apiSuccess     {String} channelId                Channel ID of the Product.
	 * @apiSuccess     {String} brandId                  Brand ID of the Product.
	 * @apiSuccess     {String} name                     Name of the Product.
	 * @apiSuccess     {String} description              Description of the Product.
	 * @apiSuccess     {String} alias                    Alias of the Product.
	 * @apiSuccess     {String} featured                 Featured Flag of the Product.
	 * @apiSuccess     {String} icon                     Icon of the Product.
	 * @apiSuccess     {String} language                 Language of the Product.
	 * @apiSuccess     {Number} status                   Status Flag of the Product.
	 * @apiSuccess     {Number} active                   Active Flag of the Product.
	 * @apiSuccess     {Date}   created                  Creation date of the Product.
	 * @apiSuccess     {Date}   modified                 Modification date of the Product.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Product.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Product.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *	   {
     *       "id": "8c17dab6-2e8e-11e4-988c-7d9574853fac",
     *       "channelId": "a1d14206-1ea9-11e4-b32d-eff91066cccf",
     *       "brandId": "bc75db6e-2dde-11e4-988c-7d9574853fac",
     *       "name": "Visa Classic",
     *       "description": null,
     *       "alias": "visa-classic",
     *       "featured": "0",
     *       "icon": null,
     *       "language": "en",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-08-28 10:37:29",
     *       "modified": "0000-00-00 00:00:00",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *   },
     *   {
     *       "id": "b4b42cb2-32fe-11e4-8ce3-5bbea8105782",
     *       "channelId": "a1d14206-1ea9-11e4-b32d-eff91066cccf",
     *       "brandId": "1c28fefa-319b-11e4-988c-7d9574853fac",
     *       "name": "Visa Gold",
     *       "description": null,
     *       "alias": "visa-gold",
     *       "featured": "0",
     *       "icon": null,
     *       "language": "en",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-09-03 02:10:26",
     *       "modified": "0000-00-00 00:00:00",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
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
		$product = new ProductsCollection($this->di);
		return $this->respond($product);
	}
	
	/**
	 * @api {post} /products/search/:id POST /products/search/:id
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i -X POST "http://apibeta.compargo.com/v1/products/search/e8f2a77f-3a19-11e4-96e3-06f157c98b98/?countryCode=ph&language=en"
	 * 
	 * @apiDescription Read data of a Product
	 * @apiName        SearchOne
	 * @apiGroup       Products
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Product unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} id                       Mandatory Product unique ID.
	 *
	 * @apiSuccess     {String} id                       ID of the Product.
	 * @apiSuccess     {String} channelId                Vertical ID of the Product.
	 * @apiSuccess     {String} brandId                  Brand ID of the Product.
	 * @apiSuccess     {String} name                     Name of the Product.
	 * @apiSuccess     {String} description              Description of the Product.
	 * @apiSuccess     {String} alias                    Alias of the Product.
	 * @apiSuccess     {String} featured                 Featured Flag of the Product.
	 * @apiSuccess     {String} icon                     Icon of the Product.
	 * @apiSuccess     {String} language                 Language of the Product.
	 * @apiSuccess     {Number} status                   Status of the Product.
     * @apiSuccess     {Number} active                   Flag of the Product.
	 * @apiSuccess     {Date}   created                  Creation date of the Product.
	 * @apiSuccess     {Date}   modified                 Modification date of the Product.
	 * @apiSuccess     {String} createdBy                ID of the User who created the Product.
	 * @apiSuccess     {String} modifiedBy               ID of the User who modified the Product.
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "id": "e8f2a77f-3a19-11e4-96e3-06f157c98b98",
     *       "channelId": "83e63b14-3a15-11e4-96e3-06f157c98b98",
     *       "brandId": "3a1a5074-3a19-11e4-96e3-06f157c98b98",
     *       "name": "Petron-BPI MasterCard",
     *       "description": "Petron-BPI MasterCard",
     *       "alias": "petron-bpi-mastercard",
     *       "featured": "0",
     *       "icon": "0",
     *       "language": "en",
     *       "status": "1",
     *       "active": "1",
     *       "created": "2014-09-12 01:12:48",
     *       "modified": "0000-00-00 00:00:00",
     *       "createdBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf",
     *       "modifiedBy": "a8838d12-1dcc-11e4-b32d-eff91066cccf"
     *     }
	 *
	 * @apiError ProductNotFound The id of the Product was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ProductNotFound"
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
		$request = $this->di->get('request');
		$parameters = $request->get();
		if (isset($parameters['query'])) {
			$product = new ProductsCollection($this->di);
			$results = $this->respond($product, $id);
		}else{
			$results = ProductsCollection::find(array(
					array('id' => $id)
				)
			);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'The requested product does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * @api {put} /products/upload/:id PUT /products/upload/:id
	 * @apiExample Example usage:
	 * curl --upload-file /home/moneymax/bpi.png "http://apibeta.compargo.com/v1/products/upload/96b3d052-3716-11e4-b18a-fe7344fb1ea4/?language=en&countryCode=ph
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      
	 * @apiDescription Upload a Product Image
	 * @apiName        Delete
	 * @apiGroup       Products
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Products unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Product Unique ID.
	 * @apiParam   {String} file                     Mandatory File.
	 *
	 * @apiSuccess {String} id                       The ID of Product.
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
	 * @apiError ProductNotFound The id of the Product was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ProductNotFound"
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
			$product = Products::findFirstById($id);
			if ($product) {
				$width = isset($request->get()['width']) ? $request->get()['width'] : '';
				$height = isset($request->get()['height']) ? $request->get()['height'] : '';
				$quality = isset($request->get()['quality']) ? $request->get()['quality'] : 85;
				
				$parameters = array(
					'prefix'        => $id . '_',
					'basename'      => $product->name,
					'uploadpath'    => $language . '/products/',
					'max_width'     => $width,
					'max_height'    => $height,
					'quality'       => $quality
				);
				
				$image = new ImageUpload();
				
				if ($filename = $image->save($requestBody, $parameters)) {
					$product->icon = $filename;
					if ($product->save()) {
						$productCollection = ProductsCollection::findFirst(array('condition' => array('id' => $id)));
						$productCollection->icon = $filename;
						if ($productCollection->save()) {
							$results[] = $productCollection;
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
	
	/**
	 * @api {post} /products/import/ POST /products/import/
	 * @apiExample Example usage:
	 * curl -i -X POST "http://apibeta.compargo.com/v1/products/import/?language=en&countryCode=ph
	 *      -H "X-COMPARE-REST-API-KEY: 1234567890"
	 *      -d "channelId=a1d14206-1ea9-11e4-b32d-eff91066cccf&
	 *          data=[{"areaName": "NCR Luzon, Visayas and Mindanao",
	 *            	   "brandName": "Bank of Commerce",
	 *            	   "companyName": "Bank of Commerce",
	 *            	   "productName": "Visa Classic",
	 *            	   "productImage": "bank-of-commerce-visa-classic.jpg",
	 *            	   "linkInformation": "http://www.bankcom.com.ph/percc.php#vc",
	 *            	   "linkApplication": "http://www.bankcom.com.ph/img/ccaf.pdf",
	 *            	   "featured": 0,
	 *            	   "hasApplyButton": 0,
	 *            	   "overlayOrClickthrough": 0,
	 *            	   "phoneNumber": 0,
	 *            	   "status": 1,
	 *            	   "providerCard": 1,
	 *            	   "premiumCard": 0,
	 *            	   "octopusCard": 0,
	 *            	   "islamicCard": 0,
	 *            	   "businessCard": 0,
	 *            	   "studentCard": 0,
	 *            	   "travelCard": 0,
	 *            	   "shoppingCard": 0,
	 *            	   "specialtyCard": 0,
	 *            	   "onlineShoppingCard": 0,
	 *            	   "coBranded": 0,
	 *            	   "greatFor1": "Get a separate credit limit for your local and foreign transactions",
	 *            	   "greatFor2": "Get up to 30% of your credit limit as cash advance",
	 *            	   "greatFor3": "Purchase new appliances, gadgets or other high-ticket items by installment",
	 *            	   "bewareThat1": 0,
	 *            	   "bewareThat2": 0,
	 *            	   "bewareThat3": 0,
	 *            	   "promoPicture": 0,
	 *            	   "promoTitle": 0,
	 *            	   "promoApplyPicture": 0,
	 *            	   "promoApplyContent": 0,
	 *            	   "ribbonBest": 0,
	 *            	   "rewardConversion": "P50 spent = 1 point",
	 *            	   "rewardConversionCondition": "Only principal cardholders can redeem reward points",
	 *            	   "rewardMultiplier": "No points multiplier",
	 *            	   "rewardMultiplierCondition": 0,
	 *            	   "rewardSpendingShopping": "SM P500 Gift Card (3,711 points)",
	 *            	   "rewardSpendingEntertainment": "SM Cinema Tickets for Two (3,149 points)",
	 *            	   "rewardSpendingDining": 0,
	 *            	   "rewardSpendingOther": 0,
	 *            	   "earningPointsOctopus": 0,
	 *            	   "earningPointsAutomaticTransaction": 0,
	 *            	   "earningPointsOnlineBillPayments": 0,
	 *            	   "earningPointsOnlineShopping": 0,
	 *            	   "earningPointsInstallment": 0,
	 *            	   "cashbackDining": 0,
	 *            	   "cashbackDiningCondition": 0,
	 *            	   "cashbackShopping": 0,
	 *            	   "cashbackShoppingCondition": 0,
	 *            	   "cashbackGroceries": 0,
	 *            	   "cashbackGroceriesCondition": 0,
	 *            	   "cashbackEntertainment": 0,
	 *            	   "cashbackEntertainmentCondition": 0,
	 *            	   "cashbackPetrol": 0,
	 *            	   "cashbackPetrolCondition": 0,
	 *            	   "cashbackLocalRetail": 0,
	 *            	   "cashbackLocalRetailCondition": 0,
	 *            	   "cashbackOverseasSpending": 0,
	 *            	   "cashbackOverseasCondition": 0,
	 *            	   "cashbackGeneral": 0,
	 *            	   "cashbackGeneralCondition": 0,
	 *            	   "cashbackOther": 0,
	 *            	   "cashbackOtherCondition": 0,
	 *            	   "cashbackMetaCondition": 0,
	 *            	   "cbeLocalRetails": 0,
	 *            	   "cbeLocalRetailsCondition": 0,
	 *            	   "cbeLocalDining": 0,
	 *            	   "cbeLocalDiningCondition": 0,
	 *            	   "cbeOverseasTransaction": 0,
	 *            	   "cbeOverseasTransactionCondition": 0,
	 *            	   "cbeOnlineShopping": 0,
	 *            	   "cbeOnlineShoppingCondition": 0,
	 *            	   "cbeOnlineBillPayment": 0,
	 *            	   "cbeOnlineBillPaymentCondition": 0,
	 *            	   "cbeOctopusAavs": 0,
	 *            	   "cbeOctopusAavsCondition": 0,
	 *            	   "cbeAutomaticTransaction": 0,
	 *            	   "cbeAutomaticTransactionCondition": 0,
	 *            	   "cbeInstalment": 0,
	 *            	   "cbeInstalmentConditi": 0,
	 *            	   "cbeSpecialCondition": 0,
	 *            	   "cbsAllNewTransactions": 0,
	 *            	   "cbsCashCoupons": 0,
	 *            	   "cbsAutopusAavs": 0,
	 *            	   "cbsPetrol": 0,
	 *            	   "cbsDining": 0,
	 *            	   "cbsShopping": 0,
	 *            	   "cbsEntertainment": 0,
	 *            	   "cbsTravel": 0,
	 *            	   "cbsSpecialCondition": 0,
	 *            	   "discountsDining": 0,
	 *            	   "discountsDiningCondition": 0,
	 *            	   "discountsShopping": 0,
	 *            	   "discountsShoppingCondition": 0,
	 *            	   "discountsGroceries": 0,
	 *            	   "discountsGroceriesCondition": 0,
	 *            	   "discountsEntertainment": 0,
	 *            	   "discountsEntertainmentCondition": 0,
	 *            	   "discountsPetrol": 0,
	 *            	   "discountsPetrolCondition": 0,
	 *            	   "discountsOther": 0,
	 *            	   "discountsOtherCondition": 0,
	 *            	   "discountsMetaCondition": 0,
	 *            	   "milesConversionLocal": 0,
	 *            	   "milesConversionConditionLocal": 0,
	 *            	   "milesConversionOverseas": 0,
	 *            	   "milesConversionConditionOverseas": 0,
	 *            	   "milesPogram": 0,
	 *            	   "insurance": 0,
	 *            	   "airportLounge": 0,
	 *            	   "travelOther": 0,
	 *            	   "fraudProtection": 0,
	 *            	   "installmentPlan": 0,
	 *            	   "personalAssistant": 0,
	 *            	   "parking": 0,
	 *            	   "creditLimit": 0,
	 *            	   "purchaseInterest": 3.5,
	 *            	   "purchaseApr": 0,
	 *            	   "cashAdvanceInterest": 0,
	 *            	   "cashAdvanceApr": 0,
	 *            	   "interestFreePeriod": 21,
	 *            	   "delinquencyRetailPurchaseApr": 0,
	 *            	   "delinquencyCashAdvanceApr": 0,
	 *            	   "annualFee": 1500,
	 *            	   "annualFeePromo": 0,
	 *            	   "annualFeeWaiver": "Request for a reversal by calling Customer Care and spend P5,000 within the specified period",
	 *            	   "foreignTransactionFee": "2% of the converted amount",
	 *            	   "annualFeeSupplementary": "P750",
	 *            	   "annualFeeSupplementaryCondition": 0,
	 *            	   "cashAdvanceFee": "5% of the amount withdrawn ",
	 *            	   "cashAdvanceFee2": 0,
	 *            	   "cardReplacementFee": "P300",
	 *            	   "annualFeeAfterFirst": 1500,
	 *            	   "partlyWaivedCondition": 0,
	 *            	   "minimumRepayment": "5% of the amount due",
	 *            	   "minimumRepayment2": "P500, whichever is higher",
	 *            	   "latePayment": "2% of the overdue amount",
	 *            	   "latePayment2": 0,
	 *            	   "creditOverLimit": 0,
	 *            	   "balanceTransferLowest": 0.88,
	 *            	   "balanceTransferMonth": 18,
	 *            	   "balanceTransferLongest": 0,
	 *            	   "balanceTransferHighlight": 0,
	 *            	   "balanceTransferAware": 0,
	 *            	   "monthlyIncomeLocals": 10000,
	 *            	   "monthlyIncomeForeigners": 0,
	 *            	   "minimumEmploymentSalaried": 0,
	 *            	   "minimumEmploymentSelfEmployed": 0,
	 *            	   "minimumAge": 21,
	 *            	   "minimumAgeSupplementary": 18,
	 *            	   "existingCardHolder": 1,
	 *            	   "nationality": 1,
	 *            	   "residence": 0,
	 *            	   "other1": 0,
	 *            	   "other2": 0,
	 *            	   "minimumAnnualIncome": 10000,
	 *            	   "maxAge": 65,
	 *            	   "language": "en"
	 *               }]"
	 * 
	 *      
	 * @apiDescription Bulk import of Products
	 * @apiName        Import
	 * @apiGroup       Products
	 *
	 * @apiHeader  {String} X-COMPARE-REST-API-KEY   Products unique access-key.
	 *
	 * @apiParam   {String} language                 Mandatory Language.
 	 * @apiParam   {String} countryCode              Mandatory Country Code.
	 * @apiParam   {String} id                       Mandatory Product Unique ID.
	 * @apiParam   {String} channelId                Mandatory ChannelId of the Product.
	 * @apiParam   {String} date                     Mandatory Data of the Product.
	 *
	 * @apiSuccess {String} id                       The ID of Product.
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
	 * @apiError ProductNotFound The id of the Product was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "ProductNotFound"
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
	public function bulkImport(){
		$results = array();
		$request = $this->di->get('request');
		$data = $request->getPost();
		$processCompany = $processBrand = $processChannel =  $processArea = 1;
		
		if (!empty($data)){
			$product = new Products();
			$productId = $product->id;
			
			$metaData = new Memory();
			$columns = $metaData->getColumnMap($product);
			
			$channelId = isset($data['channelId']) ? $data['channelId'] : '';
			$upload = isset($data['data']) ? $data['data'] : '';
			
			$channel = Channels::findFirstById($channelId);
			if (!$channel){
				throw new HTTPException(
					"Not found",
					404,
					array(
						'dev' => 'The requested channel does not exist.',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
			
			if (isJson($upload) && !empty($channelId)) {
				$productData  = $brandData = $areaData = $companyData = array();
				$companyParams = $brandParams = $channelParams = $productParams = array();
				$channelAlias = $channel->alias;
				$errors = '';
				
				$upload = json_decode($upload, true);
				if (!empty($upload)) {
					for ($i = 0; $i < count($upload); $i++) {
						$productInformation = $upload[$i];
						$company = Companies::findFirstByName($productInformation['companyName']);
						if ($company){
							$companyId = $company->id;
							$processCompany = 0;
						} else {
							$company = new Companies();
							$schemaFile = $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->companies;
							$output = readJsonFromFile($schemaFile, $this);
							if (!empty($output)) {
								$properties = $output['properties'];
								foreach ($properties as $key => $value) {
									switch($key) {
										case 'options':
											continue 2;
											break;
										case 'name':
											$companyParams[$key] = $productInformation['companyName'];
											break;
										default:
											$companyParams[$key] = !(empty($productInformation[$key]))? $productInformation[$key] : '';
											break;
										
									}
								}
							}							
							
							$valid = $company->validateProperty($companyParams, $schemaFile);
							if (!empty($valid)) {
								$errors .= implode(", ", $valid);
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
							
							$companyParams['id'] = $company->id;
							$companyParams['createdBy'] = isset($productInformation['createdBy']) ? $productInformation['createdBy'] : '';
							$companyParams['modifiedBy'] = isset($productInformation['modifiedBy']) ? $productInformation['modifiedBy'] : '';
							
							$processCompany = 1;
						}
						
						$brandName = (!empty($productInformation['brandName'])) ? $productInformation['brandName'] : $productInformation['companyName'];
						if (isset($brandName)) {
							$brand = Brands::findFirstByName($brandName);
							if ($brand){
								$brandId = $brand->id;
								$processBrand = 0;
							} else {
								$brand = new Brands();
								$schemaFile = $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->brands;
								$output = readJsonFromFile($schemaFile, $this);
								if (!empty($output)) {
									$properties = $output['properties'];
									foreach ($properties as $key => $value) {
										switch($key) {
											case 'options':
												continue 2;
												break;
											case 'name':
												$brandParams['name'] = $brandName;
												break;
											default:
												$brandParams[$key] = !(empty($productInformation[$key]))? $productInformation[$key] : '';
												break;
										}
									}
								}	

								$valid = $brand->validateProperty($brandParams, $schemaFile);
								if (!empty($valid)) {
									$errors .= implode(", ", $valid);
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

								$brandParams['id'] = $brand->id;
								$brandParams['createdBy'] = isset($productInformation['createdBy']) ? $productInformation['createdBy'] : '';
								$brandParams['modifiedBy'] = isset($productInformation['modifiedBy']) ? $productInformation['modifiedBy'] : '';								 
								$processBrand = 1;
							}
						}
						
						$areaName = $productInformation['areaName'];
						if (isset($areaName)) {
							$area = Areas::findFirstByName($areaName);
							if ($area) {
								$areaId = $area->id;		
							} else {
								$area = new Areas();
							    $schemaFile = $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->areas;
								$output = readJsonFromFile($schemaFile, $this);
								if (!empty($output)) {
									$properties = $output['properties'];
									foreach ($properties as $key => $value) {
										switch($key) {
											case 'options':
												continue 2;
												break;
											case 'name':
												$areaParams['name'] = $areaName;
												break;
											default:
												$areaParams[$key] = !(empty($productInformation[$key]))? $productInformation[$key] : '';
												break;
										}
									}
								}	
								
								$valid = $area->validateProperty($areaParams, $schemaFile);
								if (!empty($valid)) {
									$errors .= implode(", ", $valid);
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
								
								$areaParams['id'] = $area->id;
								$areaParams['name'] = $areaName;
								$areaParams['language'] = $productInformation['language'];
								$areaParams['status'] = $productInformation['status'];
								if (isset($areaParams['status'])) {
									$areaParams['active'] = ($productInformation['status'] != Areas::ACTIVE) ? 0 : 1 ;
								}
								$areaParams['createdBy'] = isset($productInformation['createdBy']) ? $productInformation['createdBy'] : '';
								$areaParams['modifiedBy'] = isset($productInformation['modifiedBy']) ? $productInformation['modifiedBy'] : '';
								
								$processArea = 1;
							}
						}

						$productName = (!empty($productInformation['productName'])) ? $productInformation['productName'] : '';
						if (isset($productName)) {
							$product = Products::findFirstByName($productName);
							if ($product) {
								$productId = $product->id;
								$processChannel = 0;
							} else {
								$params['productName'] = $productInformation['productName'];
								$params['featured'] = isset($productInformation['featured']) ? $productInformation['featured'] : 0;
								$params['productImage'] = isset($productInformation['productImage']) ? $productInformation['productImage'] : '';
								
								$product = new Products();

								$schemaFile = $this->schemaDir . $this->getDI()->getConfig()->application->jsonSchema->$channelAlias;
								$output = readJsonFromFile($schemaFile, $this);
								if (!empty($output)) {
									$properties = $output['properties'];
									foreach ($properties as $key => $value) {
										switch($key) {
											case 'options':
												continue 2;
												break;
											case 'name':
												$productData['name'] = $productInformation['productName'];
												break;
											case 'id':
												$productData['id'] = $product->id;
												break;
											default:
												$productData[$key] = !(empty($productInformation[$key]))? $productInformation[$key] : '';
												break;
											
										}
									}
								}

								$valid = $product->validateProperty($productData, $schemaFile);
								if (!empty($valid)) {					
									$errors .= implode(", ", $valid);
									throw new HTTPException(
										"Request unable to be followed due to semantic errors.",
										422,
										array(
											'dev'=> $errors,
											'internalCode' => 'P1000',
											'more' => ''
										)
									);
								}

								$productData['id'] = $product->id;
								$productData['channelId'] = $channelId;
								$productData['name'] = $productInformation['productName'];
								$productData['alias'] = '';
								$productData['language'] = $productInformation['language'];
								$productData['featured'] = $productInformation['featured'];
								$productData['icon'] = $productInformation['productImage'];
								$productData['status'] = $productInformation['status'];
								if (isset($productData['status'])) {
									$productData['active'] = ($productInformation['status'] != Products::ACTIVE) ? 0 : 1 ;
								}
								$productData['createdBy'] = isset($productInformation['createdBy']) ? $productInformation['createdBy'] : '';
								$productData['modifiedBy'] = isset($productInformation['modifiedBy']) ? $productInformation['modifiedBy'] : '';
								
								$processChannel = 1;
							}

							// only save the records when all data is valid
							if ( $processCompany ) {
								$companyParams['id'] = $company->id;
								if ( $company->create($companyParams)) {
									$companyId = $company->id;
								} else {
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

							if ( $processBrand ) {
								$brandParams['companyId'] = $company->id;
								if ( $brand->create($brandParams) ) {
									$brandId = $brand->id;
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
							
							if ( $processArea ) {
								if ($area->create($areaParams)){
									$areaId = $area->id;
								} else {
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

							if ( $processChannel ) {
								$productData['id'] = $product->id;
								$productData['brandId'] = $brandId;
								if ( $product->create($productData) ) {
									$productId = $product->id;
								} else {
									throw new HTTPException(
										"Request unable to be followed due to semantic errors",
										422,
										array(
											'dev' => $product->getMessages(),
											'internalCode' => 'P1000',
											'more' => '' // Could have link to documentation here.
										)
									);
								}
							}
							
							unset($productInformation['productName']);
							unset($productInformation['areaName']);
							unset($productInformation['brandName']);
							unset($productInformation['companyName']);
							unset($productInformation['language']);
							unset($productInformation['featured']);
							unset($productInformation['productImage']);
							
							$this->_addProductsOptions($productId, $areaId, $channelAlias, $productInformation);
						}
					}
					return $results;
				} else {
					throw new HTTPException(
					'Could not return results in specified format',
					403,
						array(
							'dev' => 'Could not understand type specified by type parameter in query string.',
							'internalCode' => 'NF1000',
							'more' => 'Type may not be implemented.'
						)
					);
				}
			} else {
				throw new HTTPException(
					'Could not return results in specified format',
					403,
					array(
						'dev' => 'Could not understand type specified by type parameter in query string.',
						'internalCode' => 'NF1000',
						'more' => 'Type may not be implemented.'
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
	}
	
	/**
	 * Responds with information about newly inserted option
	 *
	 * @method _addProductsOptions
	 * @param string productId // product id parameter of type string
	 * @param string areaId // area id parameter of type string
	 * @param string channelAlias // channel alias parameter of type string
	 * @param array productInformation // product information parameter of type array
	 * 
	 */
	private function _addProductsOptions($productId, $areaId, $channelAlias, $productInformation){
		if (!empty($productInformation)) {
			$productOptionData = $params = array();
			if ($channelAlias){
				foreach ($productInformation as $key => $value) {
					$key = trim($key);
					$value = (string) $value;
					$productOption = ProductsOptions::findFirst("productId = '" . $productId ."' AND name = '" . $key . "'");
					if  (!$productOption) {
						$productOption = new ProductsOptions();
						$productOptionData['id'] = $productOption->id;
						$productOptionData['productId'] = $productId;
						$productOptionData['areaId'] = $areaId;
						$productOptionData['name'] = $key;
						$productOptionData['value'] = $value;
						$productOptionData['status'] = $productInformation['status'];
						if (isset($productOptionData['status'])) {
							$productOptionData['active'] = ($productOptionData['status'] != ProductsOptions::ACTIVE) ? 0 : 1 ;
						}
						$productOptionData['createdBy'] = isset($productInformation['createdBy']) ? $productInformation['createdBy'] : '';
						$productOptionData['modifiedBy'] = isset($productInformation['modifiedBy']) ? $productInformation['modifiedBy'] : '';
							
						$params[$key] = $value;					
						$productOption->save($productOptionData);
					}
				}	
			}
		}
	} 
}