<?php
namespace App\Modules\Frontend\Models;

class Companies extends \Phalcon\Mvc\Collection {

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
	public $alias;
	
	/**
	 *
	 * @var string
	 */
	public $logo;

	/**
	 *
	 * @var string
	 */
	public $link;
	
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
	public $revenueValue;
	
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