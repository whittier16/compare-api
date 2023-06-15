<?php
namespace App\Modules\Frontend\Models;

class ProductsOptions extends \Phalcon\Mvc\Collection {

	/**
	 *
	 * @var string
	 */
	public $id;
	 
	/**
	 *
	 * @var string
	 */
	public $productId;
	
	/**
	 *
	 * @var string
	 */
	public $areaId;
	 
	/**
	 *
	 * @var string
	 */
	public $name;
	 
	/**
	 *
	 * @var string
	 */
	public $value;
	 
	/**
	 *
	 * @var string
	 */
	public $label;

	/**
	 *
	 * @var integer
	 */
	public $editable;
	
	/**
	 *
	 * @var integer
	 */
	public $visibility;
	
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