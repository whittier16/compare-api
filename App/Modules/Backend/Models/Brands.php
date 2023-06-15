<?php
namespace App\Modules\Backend\Models;

use App\Common\Lib\Application\Models\ModelBase,
    Phalcon\Mvc\Model\Validator\Uniqueness;

class Brands extends ModelBase {

	/**
	 *
	 * @var string
	 */
	public $id;

	/**
	 *
	 * @var integer
	 */
	public $companyId;
	 
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
				'value' => Brands::DISABLED
			)
		));

		$this->addBehavior(
			new \Phalcon\Mvc\Model\Behavior\SoftDelete(array(
				'field' => 'active',
				'value' => Brands::DISABLED
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
		
		$this->belongsTo("companyId", 'App\Modules\Backend\Models\Companies', "id", array(
			"foreignKey" => array(
				"message" => "The companyId does not exist on the Companies model."
			),
			"alias" => "Companies"
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
			'company_id' => 'companyId',
			'name' => 'name',	
			'alias' => 'alias',
			'logo' => 'logo',
			'link' => 'link',
			'alias' => 'alias',
			'description' => 'description',
			'language' => 'language',
			'revenue_value' => 'revenueValue',
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
					"field" => array("name", "alias", "status", "active"),
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