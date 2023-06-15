<?php
namespace App\Common\Lib\Application\Controllers;

use App\Common\Lib\Application\Controllers\MongodbQueryController,
	App\Common\Lib\Application\Controllers\MysqlQueryController,
	Phalcon\Mvc\Url;

/**
 *  \Phalcon\Mvc\Controller has a final __construct() method, so we can't
 *  extend the constructor (which we will need for our RESTController).
 *  Thus we extend DI\Injectable instead.
 */

class BaseController extends \Phalcon\DI\Injectable{
	
	public function __construct(){
		$di = \Phalcon\DI::getDefault();
		$this->setDI($di);
	}	
	
	public function respond($model, $id = 0){
		$query = new MysqlQueryController($this);
		
		if (method_exists($model, 'getConnection')){
			$query = new MongodbQueryController($this);
		}
		
		$result = $query->response($model, $id);
		
		return $result;
	}
}