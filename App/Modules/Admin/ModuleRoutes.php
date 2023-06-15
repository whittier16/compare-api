<?php

namespace App\Modules\Admin;

use \Phalcon\Mvc\Router\Group;

/**
 * This class defines routes for the App\Modules\Admin module
 * which will be prefixed with '/admin'
 */
class ModuleRoutes extends Group
{
	/**
	 * Initialize the router group for the Admin module
	 */
	public function initialize()
	{
		/**
		 * In the URI this module is prefixed by '/admin'
		 */
		$this->setPrefix('/admin');

		/**
		 * Configure the instance
		 */
		$this->setPaths([
			'module' => 'admin',
			'namespace' => 'App\Modules\Admin\Controllers\API\\',
			'controller' => 'index',
			'action' => 'index'
		]);

		/**
		 * Default route: 'admin-root'
		 */
		$this->addGet('', [])
			->setName('admin-root');

		/**
		 * Controller route: 'admin-controller'
		 */
		$this->addGet('/:controller', ['controller' => 1])
			->setName('admin-controller');

		/**
		 * Action route: 'admin-action'
		 */
		$this->addGet('/:controller/:action/:params', [
				'controller' => 1,
				'action' => 2,
				'params' => 3
			])
			->setName('admin-action');

		/**
		 * Add all App\Modules\Admin specific routes here
		 */
	}
}
