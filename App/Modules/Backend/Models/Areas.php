<?php
namespace App\Modules\Backend\Models;

use App\Common\Lib\Application\Models\ModelBase,
	Phalcon\Mvc\Model\Relation,
	Phalcon\Mvc\Model\Validator\Uniqueness;

class Areas extends ModelBase {


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
	public $editable = 0;
	
	/**
	 *
	 * @var integer
	 */
	public $visibility = 0;
	
	/**
	 *
	 * @var integer
	 */
	public $status = 0;
	
	/**
	 *
	 * @var integer
	 */
	public $active = 0;
	
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
	 * These set the values for soft deletion in the database (using a deleted 
	 * flag instead of removing the entry)
	 */
	const DISABLED = 0;
	const ACTIVE = 1;
	const ARCHIVE = 2;
	const DRAFT = 3;

	/**
	 * Sets up behaviors for this model.  This is run when a model is instantiated.
	 * @return void
	 */
	public function initialize(){

		/**
		 * Behaviors change the way the ORM interfaces with the Database.  SoftDelete
		 * causes the deleted flag to be set when an object is "deleted" instead of
		 * removing the row from the database.  This does not effect selects, which still
		 * require you to code in this condition.
		 */
		$this->addBehavior(
			new \Phalcon\Mvc\Model\Behavior\SoftDelete(array(
				'field' => 'status',	
				'value' => Areas::DISABLED	
			)
		));
		
		$this->addBehavior(
			new \Phalcon\Mvc\Model\Behavior\SoftDelete(array(
				'field' => 'active',
				'value' => Areas::DISABLED
			)
		));

		$this->addBehavior(
			new \Phalcon\Mvc\Model\Behavior\Timestampable(array(
				'beforeCreate' => array(
					'field' => 'created',
					'format' => 'Y-m-d H:i:s'
				),
				'beforeUpdate' => array(
					'field' => 'modified',
					'format' => 'Y-m-d H:i:s'
				)
			)
		));
		
		$this->hasMany("id", 'App\Modules\Backend\Models\ProductsOptions', "areaId",
			array(
				"foreignKey" => array(
					"action" => Relation::ACTION_CASCADE,
					"message" => "The area cannot be deleted because other products options are using it."
				)
			)
		);
		
		return;
	}
	
	/**
	 * Independent Column Mapping.
	 * @return array
	 */
	public function columnMap()
	{
		return array(
			'id' => 'id',
			'name' => 'name',
			'category' => 'category',
			'description' => 'description',
			'language' => 'language',
			'bounds' => 'bounds',
            'parent_id' => 'parentId',
			'lft' => 'lft',
			'rght' => 'rght',
			'scope' => 'scope',
			'editable' => 'editable',
			'visibility' => 'visibility',
			'status' => 'status',
			'active' => 'active',	
			'created' => 'created',
			'modified' => 'modified',
			'created_by' => 'created_by',
			'modified_by' => 'modified_by'
		);
	}
	
	/**
	 * Set the creation date
	 */
	public function beforeValidationOnCreate()
	{
		$this->created = date('Y-m-d H:i:s');
	}
	
	/**
	 * Set the modification date
	 */
	public function beforeValidationOnUpdate()
	{
		$this->modified = date('Y-m-d H:i:s');
	}
	
	/**
	 * Validate field
	 */
	public function validation()
	{
		//Name, Status and Active must be unique
		$this->validate(new Uniqueness(
				array(
					"field" => array("name", "status", "active"),
					"message" => 'The name, alias and status must be unique.'
				)
			)
		);
	
		//Check if any messages have been produced
		if ($this->validationHasFailed() == true) {
			return false;
		}
	}
	
	/**
	 * Set the ID
	 */
	public function setId()
	{
		$this->id = $this->uuid();
	}
	
	/**
	 * Get the ID
	 */
	public function getId()
	{
		return $this->id;
	}
}