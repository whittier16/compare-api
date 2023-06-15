<?php

namespace App\Modules\Leads;

use \Phalcon\Mvc\Router\Group;

/**
 * This class defines routes for the App\Modules\Leads module
 * which will be prefixed with '/leads'
 */
class ModuleRoutes extends Group
{
	/**
	 * Initialize the router group for the Leads module
	 */
	public function initialize()
	{
		/**
		 * In the URI this module is prefixed by '/leads'
		 */
		$this->setPrefix('/leads');

		/**
		 * Configure the instance
		 */
		$this->setPaths([
			'module' => 'leads',
			'namespace' => 'App\Modules\Leads\Controllers\API\\',
			'controller' => 'index',
			'action' => 'index'
		]);

		/**
		 * Default route: 'leads-root'
		 */
		$this->addGet('', [])
			->setName('leads-root');

		/**
		 * Controller route: 'leads-controller'
		 */
		$this->addGet('/:controller', ['controller' => 1])
			->setName('leads-controller');

		/**
		 * Action route: 'leads-action'
		 */
		$this->addGet('/:controller/:action/:params', [
				'controller' => 1,
				'action' => 2,
				'params' => 3
			])
			->setName('leads-action');

		/**
		 * Add all App\Modules\Leads specific routes here
		 */
	}
}
