<?php
namespace App\Common\Lib\Application\Controllers;

use App\Common\Lib\Application\Exceptions\HTTPException;
/**
 * Base RESTful Controller.
 * Supports queries with the following paramters:
 *   Searching:
 *     	query={"searchField1":"value1","searchField2":"value2"}
 *   Partial Responses:
 *     	fields=field1,field2,field3
 *   Sort:
 *   	sort=field1,field2,-field3
 *   Include:
 *   	include=class1,class2
 *   Limits:
 *     	limit=10
 *   Partials:
 *     	offset=20
 *   Count:
 *     	count=0
 */
class RESTController extends BaseController{

	/**
	 * If query string contains 'query' parameter.
	 * This indicates the request is searching an entity
	 * @var boolean
	 */
	protected $isSearch = false;
	
	/**
	 * If query contains 'include' parameter.
	 * This indicates the request is searching relational data
	 * @var boolean
	 */
	protected $isInclude = false;
	/**
	 * If query contains 'fields' parameter.
	 * This indicates the request wants back only certain fields from a record
	 * @var boolean
	 */
	protected $isPartial = false;

	/**
	 * If query contains 'sort' parameter.
	 * This indicates the request is sorting only certain fields from a record
	 * @var boolean
	 */
	protected $isCount = false;
	
	/**
	 * If query contains 'count' parameter.
	 * This indicates the request wants back total number of records
	 * @var boolean
	 */
	protected $isSort = false;
	
	/**
	 * Set when there is a 'language' query parameter
	 * @var array
	 */
	protected $language = null;
	
	/**
	 * Set when there is a 'limit' query parameter
	 * @var integer
	 */
	protected $limit = null;

	/**
	 * Set when there is an 'offset' query parameter
	 * @var integer
	 */
	protected $offset = null;

	/**
	 * Set when there is a 'sort' query parameter
	 * @var array
	 */
	protected $sort = null;
	
	/**
	 * Set when there is a 'count' query parameter
	 * @var array
	 */
	protected $count = null;
	
	/**
	 * Array of fields requested to be searched against
	 * @var array
	 */
	protected $sortFields = null;
	
	/**
	 * Array of fields requested to be searched against
	 * @var array
	 */
	protected $searchFields = null;
	
	/**
	 * Array of objects requested to be returned
	 * @var array
	 */
	protected $relatedObjects = null;

	/**
	 * Array of fields requested to be returned
	 * @var array
	 */
	protected $partialFields = null;

	/**
	 * Sets which fields may be searched against, and which fields are allowed to be returned in
	 * partial responses.  This will be overridden in child Controllers that support searching
	 * and partial responses.
	 * @var array
	 */
	protected $allowedFields = array(
		'search' => array(),
		'partials' => array(),
		'sort' => array(),
		'whitelist' => array()	
	);
	
	/**
	 * Sets which objects may be searched against, and which objects are allowed to be returned in
	 * partial responses.
	 * @var array
	 */
	protected $allowedObjects = array();
	
	/**
	 * Sets logical operators
	 * @var array
	 */
	protected $logicalOperators = array(
		'and',
		'or',
		'not'
	);
	
	/**
	 * Constructor, calls the parse method for the query string by default.
	 * @param boolean $parseQueryString true Can be set to false if a controller needs to be called
	 *        from a different controller, bypassing the $allowedFields parse
	 * @param boolean $parseQueryObject true Can be set to false if a controller needs to be called
	 *        from a different controller, bypassing the $allowedObjects parse
	 * @return void
	 */
	public function __construct($parseQueryString = false, $parseQueryObject = false){
		parent::__construct();
		
		if ($parseQueryString || $parseQueryObject){
			$this->parseRequest($this->allowedFields, $this->allowedObjects);
		}
		return;
	}
	
	/**
	 * Parses out the search parameters from a request.
	 * Unparsed, they will look like this:
	 *     and(ne(name,MasterCard),in(id,[522,523]),ne(vertical_id,1),out(id,[217,220]),like(logo,dk%),ne(id,217))
	 * Parsed:
	 *     array('name'=>'Benjamin Franklin', 'location'=>'Philadelphia')
	 * @param  string $unparsed Unparsed search string
	 * @return array            An array of fieldname=>value search parameters
	 */
	protected function parseSearchParameters($unparsed){
		$mapped = array();
		// Strip parents that come with the request string
		if (preg_match_all("/^(and|or)\((.*)\)$/", $unparsed, $exprs)) {
			$operator = $exprs[1][0];
			$queries = $exprs[2][0];
			//Split the strings at their colon, set left to key, and right to value.
			if (@preg_match_all("/(,?)(?<operator>eq|ne|gt|gte|lte|lt|in|like|nin)(?<right>\([a-zA-Z0-9,\[\]%_\p{L}\p{M}\p{Nd}\s]*\))/u", $queries, $matches)){
				$funcs = $matches['operator'];
				$right = $matches['right'];
				for ($i = 0; $i < count($funcs); $i++) {
					$fields = explode(',', trim($right[$i], '()'));
					if ('in' == $funcs[$i] || 'nin' == $funcs[$i]) {
						$fields = trim($right[$i], '()');
						if (preg_match_all("/([a-zA-Z].*)(,)(\[.*\])/", $fields, $in)){
							$field = $in[1][0];
							$value = trim("('". implode("','", explode(',',trim($in[3][0], '[]'))) . "')", '""');
						}
					}else{
						$field = $fields[0];
						$value = $fields[1];
					}
					$mapped['fields'][$field] = $field;
					$mapped['unparsed'][$funcs[$i]][] = array($field => $value);
				}
			}
			$mapped['operator'] = $operator;
		}
		return $mapped;
	}
	
	/**
	 * Parses out the search parameters from a request.
	 * Unparsed, they will look like this:
	 *     {"name":"MasterCard"}
	 * Parsed:
	 *     array('name'=>'Master Card')
	 * @param  string $unparsed Unparsed search string
	 * @return array            An array of fieldname=>value search parameters
	 */
	protected function parseJsonSearchParameters($unparsed){
		$mapped = array();
		
		// Strip parents that come with the request string
		foreach ($unparsed as $unparsedKey => $unparsedValue){
			if ('$or' == $unparsedKey) {
				$mapped['operator'] = 'or';
				foreach ($unparsedValue as $key => $value) {
					$mapped['fields'][] = $key;
					$mapped['unparsed']['eq'][][$key] = $value; 
				}
			}else{
				$mapped['operator'] = 'and';
				if (!is_array($unparsedValue)){
					$mapped['fields'][] = $unparsedKey;
					$mapped['unparsed']['eq'][][$unparsedKey] = $unparsedValue;
				}else{
					foreach ($unparsedValue as $key => $value) {
						$mapped['fields'][] = $unparsedKey;
						if ('$nin' == $key || '$in' == $key) {
							$mapped['unparsed'][trim($key, '$')][][$unparsedKey] = $value;
						} else {
							if (!is_array($value)){
								$mapped['unparsed'][trim($key, '$')][][$unparsedKey] = $value;
							} else {
								foreach ($value as $operationKey => $operationvalue) 
								{
									$mapped['unparsed'][trim($operationKey, '$')][][$unparsedKey] = $operationvalue; 
								}
							}
						}
					}
				}
			}
		}
		return $mapped;
	}
	
	/**
	 * Parses out partial fields to return in the response.
	 * Unparsed:
	 *     (id,name,location)
	 * Parsed:
	 *     array('id', 'name', 'location')
	 * @param  string $unparsed Unparsed string of fields to return in partial response
	 * @return array            Array of fields to return in partial response
	 */
	protected function parsePartialFields($unparsed){
		return explode(',', $unparsed);
	}
	
	/**
	 * Parses out objects to return in the response.
	 * Unparsed:
	 *     (attributes)
	 * Parsed:
	 *     array('attributes')
	 * @param  string $unparsed Unparsed string of objects to return in partial response
	 * @return array            Array of objects to return in partial response
	 */
	protected function parseRelatedObjects($unparsed){
		return explode(',', $unparsed);
	}
	
	/**
	 * Parses out sort fields to return in the response.
	 * Unparsed:
	 *     (id,name,location)
	 * Parsed:
	 *     array('id', 'name', 'location')
	 * @param  string $unparsed Unparsed string of fields to return in sort response
	 * @return array            Array of fields to return in sort response
	 */
	protected function parseSortFields($unparsed){
		// Strip parents that come with the request string
		// Now we have an array of "key:value" strings.
		$splitFields = explode(',', $unparsed);
		$mapped = array();
		
		// Split the strings at their colon, set left to key, and right to value.
		foreach ($splitFields as $field) {  
			$mapped['fields'][] = trim($field, '-');
			$mapped['unparsed'][] = $field;
		}
		return $mapped;
	}

	/**
	 * Main method for parsing a query string.
	 * Finds search paramters, partial response fields, sort, limits, and offsets.
	 * Sets Controller fields for these variables.
	 *
	 * @param  array $allowedFields Allowed fields array for search, sort and partials
	 * @return boolean              Always true if no exception is thrown
	 */
	protected function parseRequest($allowedFields, $allowedObjects){
		$request = ($this->di->get('request')) ? $this->di->get('request') : $this->di->get('requestBody');
		$searchParams = $request->get('query', null, null);
		
		$language = $request->get('language', null, null);
		$fields = $request->get('fields', null, null);
		$sort = $request->get('sort', null, null);
		$objects = $request->get('include', null, null);
		$count = $request->get('count', null, null);
		
		// Set language, limits and offset, elsewise allow them to have defaults set in the Controller
		$this->limit = ($request->get('limit', null, null)) ?: $this->limit;
		$this->offset = ($request->get('offset', null, null)) ? : $this->offset;
		$this->language = ($request->get('language', null, null)) ? : $this->language;
		
		// If there's a 'q' parameter, parse the fields, then determine that all the fields in the search
		// are allowed to be searched from $allowedFields['search']
		if ($searchParams){
			$this->isSearch = true;
			$this->searchFields = $this->parseSearchParameters($searchParams);
			
			if (isJson($searchParams)){
				$searchParams = json_decode($searchParams, true);
				$this->searchFields = $this->parseJsonSearchParameters($searchParams);
			} 
			
			// Determines if fields is a strict subset of allowed fields
			if (array_diff($this->searchFields['fields'], $this->allowedFields['search'])){
				throw new HTTPException(
					"The fields you asked for cannot be returned.",
					401,
					array(
						'dev' => 'You requested to return fields that are not available to be returned in partial responses.',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					));
			}
		}

		// If there's a 'fields' parameter, this is a partial request.  Ensures all the requested fields
		// are allowed in partial responses.
		if ($fields){
			$this->isPartial = true;
			$this->partialFields = $this->parsePartialFields($fields);

			// Determines if fields is a strict subset of allowed fields
			if (array_diff($this->partialFields, $this->allowedFields['partials'])){
				throw new HTTPException(
					"The fields you asked for cannot be returned.",
					401,
					array(
						'dev' => 'You requested to return fields that are not available to be returned in partial responses.',
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
				));
			}
		}
		
		// If there's a 'sort' parameter, this is a sort request.  Ensures all the requested fields
		// are allowed in sort responses.
		if ($sort){
			$this->isSort = true;
			$this->sortFields = $this->parseSortFields($sort);
			
			// Determines if fields is a strict subset of allowed fields
			if (array_diff($this->sortFields['fields'], $this->allowedFields['sort'])){
				throw new HTTPException(
					"The fields you asked for cannot be returned.",
					401,
					array(
						'dev' => 'You requested to return fields that are not available to be returned in partial responses.',
						'internalCode' => 'O1000',
						'more' => '' // Could have link to documentation here.
					));
			}
		}
		
		// If there's an 'include' parameter, this is an include request.  Ensures all the requested related objects
		// are allowed in include responses.
		if ($objects){
			$this->isInclude = true;
			$this->relatedObjects = $this->parseRelatedObjects($objects);
			
			// Determines if fields is a strict subset of allowed objects
			if (array_diff($this->relatedObjects, $this->allowedObjects)){
				throw new HTTPException(
					"The objects you asked for cannot be returned.",
					401,
					array(
						'dev' => 'You requested to return objects that are not available to be returned in partial responses.',
						'internalCode' => 'O1000',
						'more' => '' // Could have link to documentation here.
					));
			}
		}
		
		return true;
	}

	/**
	 * Provides a base CORS policy for routes like '/users' that represent a Resource's base url
	 * Origin is allowed from all urls.  Setting it here using the Origin header from the request
	 * allows multiple Origins to be served.  It is done this way instead of with a wildcard '*'
	 * because wildcard requests are not supported when a request needs credentials.
	 *
	 * @return true
	 */
	public function optionsBase(){
		$response = $this->di->get('response');
		$response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, HEAD');
		$response->setHeader('Access-Control-Allow-Origin', $this->di->get('request')->header('Origin'));
		$response->setHeader('Access-Control-Allow-Credentials', 'true');
		$response->setHeader('Access-Control-Allow-Headers', "origin, x-requested-with, content-type");
		$response->setHeader('Access-Control-Max-Age', '86400');
		return true;
	}

	/**
	 * Provides a CORS policy for routes like '/users/123' that represent a specific resource
	 *
	 * @return true
	 */
	public function optionsOne(){
		$response = $this->di->get('response');
		$response->setHeader('Access-Control-Allow-Methods', 'GET, PUT, PATCH, DELETE, OPTIONS, HEAD');
		$response->setHeader('Access-Control-Allow-Origin', $this->di->get('request')->header('Origin'));
		$response->setHeader('Access-Control-Allow-Credentials', 'true');
		$response->setHeader('Access-Control-Allow-Headers', "origin, x-requested-with, content-type");
		$response->setHeader('Access-Control-Max-Age', '86400');
		return true;
	}
}