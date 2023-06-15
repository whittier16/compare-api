<?php
namespace App\Modules\Admin\Models;

use App\Common\Lib\Application\Models\ModelBase,
	Phalcon\Mvc\Model\Relation,
	Phalcon\Mvc\Model\Validator\Uniqueness;

class Groups extends ModelBase {

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
		 * Defines the connection service for the model
		 */
		$this->setConnectionService('dbMysql');
		
		/**
		 * Behaviors change the way the ORM interfaces with the Database.  SoftDelete
		 * causes the deleted flag to be set when an object is "deleted" instead of
		 * removing the row from the database.  This does not effect selects, which still
		 * require you to code in this condition.
		 */
		$this->addBehavior(
			new \Phalcon\Mvc\Model\Behavior\SoftDelete(array(
				'field' => 'status',
				'value' => Groups::DISABLED
			)
		));
		
		$this->addBehavior(
			new \Phalcon\Mvc\Model\Behavior\SoftDelete(array(
				'field' => 'active',
				'value' => Groups::DISABLED
			)
		));

		$this->hasOne("id", 'App\Modules\Admin\Models\Users', "groupId", array(
			"foreignKey" => array(
				"action" => Relation::ACTION_CASCADE,
				"message" => "The group cannot be deleted because other users are using it."
				)
			)
		);
		
		return;
	}
	
	public function validation()
	{
		//Name, Status, Alias, and Active must be unique
		$this->validate(new Uniqueness(
				array(
					"field" => array("name", "status", "alias", "active"),
					"message" => "The name, alias and status must be unique."
				)
			)
		);
	
		//Check if any messages have been produced
		if ($this->validationHasFailed() == true) {
			return false;
		}
	}
	
	public function beforeDelete()
	{
		//Name, Status, Alias, and Active must be unique
		$this->validate(new Uniqueness(
				array(
					"field" => array("name", "status", "alias", "active"),
					"message" => "The name, alias and status must be unique."
				)
			)
		);
	
		//Check if any messages have been produced
		if ($this->validationHasFailed() == true) {
			return false;
		}
	}
	
	/**
	 * Returns table name
	 */
	public function getSource()
	{
		return 'admin_groups';
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
			'description' => 'description',
			'alias' => 'alias',
			'status' => 'status',
			'active' => 'active',
			'created' => 'created',
			'modified' => 'modified',
			'created_by' => 'createdBy',
			'modified_by' => 'modifiedBy'
		);
	}
	
	/**
	 * Set ID of Group
	 */
	public function setId()
	{
		$this->id = $this->getDI()->getUtils()->uuid();
	}
	
	/**
	 * Get ID of Group
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
}