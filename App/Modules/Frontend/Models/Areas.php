<?php
namespace App\Modules\Frontend\Models;

class Areas extends \Phalcon\Mvc\Collection {


	/**
	 *
	 * @var string
	 */
	public $id;
	 
	/**
	 *
	 * @var string
	 */
	public $name;
	
	/**
	 *
	 * @var string
	 */
	public $category;
	 
	/**
	 *
	 * @var string
	 */
	public $description;
	 
	/**
	 *
	 * @var string
	 */
	public $language;
	
	/**
	 *
	 * @var string
	 */
	public $bounds;
	
	/**
	 *
	 * @var string
	 */
	public $parentId;
	
	/**
	 *
	 * @var string
	 */
	public $lft;
	
	/**
	 *
	 * @var string
	 */
	public $rght;

	/**
	 *
	 * @var string
	 */
	public $scope;
	
	/**
	 *
	 * @var integer
	 */
	public $status;
	
	/**
	 *
	 * @var integer
	 */
	public $active;
	
	/**
	 *
	 * @var string
	 */
	public $created = '0000-00-00 00:00:00';
	
	/**
	 *
	 * @var string
	 */
	public $modified = '0000-00-00 00:00:00';
	
	/**
	 *
	 * @var string
	 */
	public $createdBy;
	
	/**
	 *
	 * @var string
	 */
	public $modifiedBy;

	/**
	 * Sets up behaviors for this model.  This is run when a model is instantiated.
	 * @return void
	 */
	public function initialize(){
		
		return;
	}
}