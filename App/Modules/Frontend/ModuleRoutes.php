<?php

namespace App\Modules\Backend;

use \Phalcon\Mvc\Router\Group;

/**
 * This class defines routes for the App\Modules\Backend module
 * which will be prefixed with '/backend'
 */
class ModuleRoutes extends Group
{
	/**
	 * Initialize the router group for the Frontend module
	 */
	public function initialize()
	{
		/**
		 * In the URI this module is prefixed by '/backend'
		 */
		$this->setPrefix('/backend');

		/**
		 * Configure the instance
		 */
		$this->setPaths([
			'module' => 'backend',
			'namespace' => 'App\Modules\Backend\Controllers\API\\',
			'controller' => 'index',
			'action' => 'index'
		]);

		/**
		 * Default route: 'frontend-root'
		 */
		$this->addGet('', [])
			->setName('backend-root');

		/**
		 * Controller route: 'frontend-controller'
		 */
		$this->addGet('/:controller', ['controller' => 1])
			->setName('backend-controller');

		/**
		 * Action route: 'frontend-action'
		 */
		$this->addGet('/:controller/:action/:params', [
				'controller' => 1,
				'action' => 2,
				'params' => 3
			])
			->setName('backend-action');

		/**
		 * Add all App\Modules\Frontend specific routes here
		 */
	}
}
