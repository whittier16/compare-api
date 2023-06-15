<?php
namespace App\Modules\Backend\Models;

use App\Common\Lib\Application\Models\ModelBase,
	Phalcon\Mvc\Model\Relation,
	Phalcon\Mvc\Model\Validator\Uniqueness;

class Channels extends ModelBase {

	/**
	 *
	 * @var string
	 */
	public $id;
	
	/**
	 *
	 * @var string
	 */
	public $verticalId;
	 
	/**
	 *
	 * @var string
	 */
	public $name;
	 
	/**
	 *
	 * @var string
	 */
	public $description;
	 
	/**
	 *
	 * @var string
	 */
	public $alias;
	
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
	 * @var integer
	 */
	public $revenueValue;
	
	/**
	 *
	 * @var integer
	 */
	public $perPage;
	
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
				'value' => Channels::DISABLED
			)
		));
		
		$this->addBehavior(
			new \Phalcon\Mvc\Model\Behavior\SoftDelete(array(
				'field' => 'active',
				'value' => Channels::DISABLED
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
		
		$this->hasMany("id", '\App\Modules\Backend\Models\Products', "channelId",
			array(
	            "foreignKey" => array(
	                "action" => Relation::ACTION_CASCADE,
	                "message" => "The channel cannot be deleted because other products are using it."
	            )
			)
		);

		$this->hasMany("id", '\App\Modules\Backend\Models\ChannelsOptions', "channelId",
			array(
	            "foreignKey" => array(
	                "action" => Relation::ACTION_CASCADE,
	                "message" => "The channel cannot be deleted because other channels options are using it."
	            )
			)
		);
		
		$this->belongsTo("verticalId", 'App\Modules\Backend\Models\Verticals', "id", array(
			"foreignKey" => array(
				"message" => "The verticalId does not exist on the Verticals model."
			)
		));
		
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
			'vertical_id' => 'verticalId',
			'name' => 'name',
			'description' => 'description',
			'alias' => 'alias',
			'revenue_value' => 'revenueValue',
			'per_page' => 'perPage',
			'status' => 'status',
			'active' => 'active',
			'created' => 'created',
			'modified' => 'modified',
			'created_by' => 'createdBy',
			'modified_by' => 'modifiedBy'
		);
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
					"message" => 'The name and status must be unique.'
				)
			)
		);
	
		//Check if any messages have been produced
		if ($this->validationHasFailed() == true) {
			return false;
		}
	}
	
	/**
	 * Set the creation date
	 * @return string
	 */
	public function beforeValidationOnCreate()
	{
		$this->created = date('Y-m-d H:i:s');
	}
	
	/**
	 * Set the modification date
	 * @return string
	 */
	public function beforeValidationOnUpdate()
	{
		$this->modified = date('Y-m-d H:i:s');
	}
	
	/**
	 * Set the ID
	 * @return string
	 */
	public function setId()
	{
		$this->id = $this->uuid();
	}
	
	/**
	 * Get the ID
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Set Alias
	 */
	public function setAlias($alias = '')
	{
		if (!$alias) {
			$alias = \Phalcon\Tag::friendlyTitle($this->name, "-");
		}
		$this->alias = $alias;
	}
	
	/**
	 * Get Alias
	 */
	public function getAlias()
	{
		return $this->alias;
	}	
}