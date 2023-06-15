<?php
namespace App\Modules\Backend\Models;

use App\Common\Lib\Application\Models\ModelBase,
	Phalcon\Mvc\Model\Relation,
	Phalcon\Mvc\Model\Validator\Uniqueness;

class Products extends ModelBase {

	/**
	 *
	 * @var string
	 */
	public $id;
	 
	/**
	 *
	 * @var string
	 */
	public $channelId;
	
	/**
	 *
	 * @var string
	 */
	public $brandId;
	 
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
	public $featured;
	 
	/**
	 *
	 * @var string
	 */
	public $icon;
	 
	/**
	 *
	 * @var string
	 */
	public $language;
	
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
				'value' => Products::DISABLED
			)
		));
		
		$this->addBehavior(
				new \Phalcon\Mvc\Model\Behavior\SoftDelete(array(
					'field' => 'active',
					'value' => Products::DISABLED
				)
			)
		);
		
		/**
		 * A Product only has a Channel, and Brand, but a Channel, and Brand have many Products
		 */
		$this->hasMany("id", 'App\Modules\Backend\Models\ProductsOptions', "productId",
			array(
				"foreignKey" => array(
					"action" => Relation::ACTION_CASCADE,
					"message" => "The product cannot be deleted because other Products options are using it."
				)
			)
       	);

		$this->belongsTo("channelId", 'App\Modules\Backend\Models\Channels', "id", array(
			"foreignKey" => array(
				"message" => "The channelId does not exist on the Channels model."
			)
		));
		
		$this->belongsTo("brandId", 'App\Modules\Backend\Models\Brands', "id", array(
			"foreignKey" => array(
				"message" => "The brandId does not exist on the Brands model."
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
			'channel_id' => 'channelId',
			'brand_id' => 'brandId',
			'name' => 'name',
			'description' => 'description',
			'alias' => 'alias',
			'featured' => 'featured',
			'icon' => 'icon',
			'status' => 'status',
			'active' => 'active',
			'language' => 'language',
			'created' => 'created',
			'modified' => 'modified',
			'created_by' => 'createdBy',
			'modified_by' => 'modifiedBy'
		);
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