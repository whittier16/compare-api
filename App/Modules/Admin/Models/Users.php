<?php
namespace App\Modules\Admin\Models;

use App\Common\Lib\Application\Models\ModelBase,
	Phalcon\Mvc\Model\Validator\Uniqueness,
	Phalcon\Mvc\Model\Validator\Email;

class Users extends ModelBase {

	/**
	 *
	 * @var string
	 */
	public $id;
	 
	/**
	 *
	 * @var string
	 */
	public $groupId;
	 
	/**
	 *
	 * @var string
	 */
	public $emailAddress;
	 
	/**
	 *
	 * @var string
	 */
	public $firstName;
	 
	/**
	 *
	 * @var string
	 */
	public $lastName;
	
	/**
	 *
	 * @var string
	 */
	public $password;
	
	/**
	 *
	 * @var string
	 */
	public $salt;
	
	/**
	 *
	 * @var string
	 */
	public $hash;
	
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
				'value' => Users::DISABLED
			)
		));
		
		$this->addBehavior(
			new \Phalcon\Mvc\Model\Behavior\SoftDelete(array(
				'field' => 'active',
				'value' => Users::DISABLED
			)
		));
		
		$this->belongsTo("groupId", 'App\Modules\Admin\Models\Groups', "id", array(
			"foreignKey" => array(
				"message" => "The groupId does not exist on the Groups model."
			),
			"alias" => 'Groups'
		));
		
		return;
	}
	
	public function validation()
	{
		//Email address must be unique
		$this->validate(new Uniqueness(
			array(
				"field" => array("emailAddress", "status", "active"),
				"message" => "The email address, status and active must be unique."
			)
		));
		
		$this->validate(new Email(
			array(
				"field" => "emailAddress",
				"message" => "The email address must be valid email."
			)
		));
		
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
					"field" => array("emailAddress", "status", "active"),
					"message" => "The email address and status must be unique."
				)
			)
		);
	
		//Check if any messages have been produced
		if ($this->validationHasFailed() == true) {
			return false;
		}
	}
	
	/**
	 * This model is mapped to the table attributes
	 */
	public function getSource()
	{
		return 'admin_users';
	}
	
	/**
	 * Independent Column Mapping.
	 * @return array
	 */
	public function columnMap()
	{
		return array(
			'id' => 'id',
			'group_id' => 'groupId',
			'email_address' => 'emailAddress',
			'first_name' => 'firstName',
			'last_name' => 'lastName',
			'password' => 'password',
			'salt' => 'salt',
			'hash' => 'hash',
			'status' => 'status',
			'active' => 'active',
			'created' => 'created',
			'modified' => 'modified',
			'created_by' => 'createdBy',
			'modified_by' => 'modifiedBy'
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
	 * Sets ID of User
	 */
	public function setId()
	{
		$this->id = $this->getDI()->getUtils()->uuid();
	}
	
	/**
	 * Gets ID of User
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Authenticate login credentials
	 */
	public function authenticate($email, $password){
		$user = Users::findFirst('emailAddress = "' .  $email .'"');
		if (empty($user)) {
			return false;
		}

		$salt = $user->salt;
		$hash = $user->hash;
		$password = $salt . $password;
		
		$isPasswordOk = validate_password($password, $hash);
		if (!$isPasswordOk) {
			return false;
		}
		
		return $user;
	}
}