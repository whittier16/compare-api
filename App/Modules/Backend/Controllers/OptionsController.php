<?php
namespace App\Modules\Backend\Controllers;

use App\Modules\Backend\Models\Options,
	App\Modules\Frontend\Models\Options as OptionsCollection,
	App\Common\Lib\Application\Controllers\RESTController,
	App\Common\Lib\Application\Exceptions\HTTPException;

class OptionsController extends RESTController{

	/**
	 * Sets which fields may be searched against, and which fields are allowed to be returned in
	 * partial responses. 
	 * @var array
	 */
	protected $allowedFields = array(
		'search' => array(
			'id',
			'type', 
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
			'type', 
			'name', 
			'value',
			'label',
			'status',
			'editable',
			'visibility',
			'active',
			'created',
			'modified',
			'createdBy',
			'modifiedBy'
		),
		'sort' => array(
			'id',
			'type', 
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
	 * Responds with information about several options
	 *
	 * @method get
	 * @return json/xml data
	 */
	public function get(){
		$option = new OptionsCollection($this->di);
		return $this->respond($option);
	}

	/**
	 * Responds with information about an option
	 *
	 * @method getOne
	 * @param int id // id parameter of type integer
	 * @return json/xml data
	 */
	public function getOne($id){
		$request = $this->di->get('request');
		$parameters = $request->get();
		if (count($parameters) > 1) {
			$option = new OptionsCollection($this->di);
			$results = $this->respond($option, $id);
		}else{
			$results = OptionsCollection::findFirstById($id);
		}
		return $results;
	}

	/**
	 * Responds with information about newly inserted option
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function post(){
		$results = array();
		$request = $this->di->get('request');
		$stack = $request->get();
		$parameters = array_shift($stack);
		
		$option = new Options();
		$stack['id'] = $option->id;
		if ($option->save($stack)){
			$results['id'] = $option->id;
		}else{
			throw new HTTPException(
				"Request unable to be followed due to semantic errors",
				422,
				array(
					'dev' => $option->getMessages(),
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
	
	/**
	 * Responds with information about deleted record
	 *
	 * @method delete
	 * @return json/xml data
	 */
	public function delete($id){
		$option = Options::findFirst($id);
		return $option->delete();
	}
 	
	/**
	 * Responds with information about updated inserted option
	 *
	 * @method put
	 * @return json/xml data
	 */
	public function put($id){
		$results = array();
		$metaData = new \Phalcon\Mvc\Model\MetaData\Memory();
		$request = $this->di->get('requestBody');
		$option = Options::findFirstById($id);
		if (!$option){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		} else {
			$params['type'] = isset($request['type']) ? $request['type'] : $option->type;
			$params['name'] = isset($request['name']) ? $request['name'] : $option->name;
			$params['value'] = isset($request['value']) ? $request['value'] : $option->value;
			$params['label'] = isset($request['label']) ? $request['label'] : $option->label;
			$params['status'] = isset($request['status']) ? $request['status'] : $option->status;
			if ($option->save($params, $metaData->getColumnMap(new Options()))){
				$results['id'] = $option->id;
			} else {
				throw new HTTPException(
					"Request unable to be followed due to semantic errors",
					422,
					array(
						'dev' => $option->getMessages(),
						'internalCode' => 'P1000',
						'more' => '' // Could have link to documentation here.
					)
				);
			}
		}
		return $results;
	}
	
	/**
	 * Responds with information about several options
	 *
	 * @method searches
	 * @return json/xml data
	 */
	public function searches(){
		$option = new OptionsCollection($this->di);
		return $this->respond($option);
	}
	
	/**
	 * Responds with information about an option
	 *
	 * @method searchOne
	 * @return json/xml data
	 */
	public function searchOne($id){
		$results = array();
		$request = $this->di->get('requestBody');
		$parameters = $request->get();
		if (count($parameters) > 1) {
			$option = new OptionsCollection($this->di);
			$results = $this->respond($option, $id);
		}else{
			$results = OptionsCollection::findFirstById($id);
		}
		if (!$results){
			throw new HTTPException(
				"Not found",
				404,
				array(
					'dev' => 'Option does not exist',
					'internalCode' => 'P1000',
					'more' => '' // Could have link to documentation here.
				)
			);
		}
		return $results;
	}
}