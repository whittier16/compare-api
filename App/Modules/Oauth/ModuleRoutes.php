<?php

namespace App\Modules\Oauth;

use \Phalcon\Mvc\Router\Group;

/**
 * This class defines routes for the App\Modules\Oauth module
 * which will be prefixed with '/oauth'
 */
class ModuleRoutes extends Group
{
	/**
	 * Initialize the router group for the Oauth module
	 */
	public function initialize()
	{
		/**
		 * In the URI this module is prefixed by '/oauth'
		 */
		$this->setPrefix('/oauth');

		/**
		 * Configure the instance
		 */
		$this->setPaths([
			'module' => 'oauth',
			'namespace' => 'App\Modules\Oauth\Controllers\API\\',
			'controller' => 'index',
			'action' => 'index'
		]);

		/**
		 * Default route: 'oauth-root'
		 */
		$this->addGet('', [])
			->setName('oauth-root');

		/**
		 * Controller route: 'oauth-controller'
		 */
		$this->addGet('/:controller', ['controller' => 1])
			->setName('oauth-controller');

		/**
		 * Action route: 'oauth-action'
		 */
		$this->addGet('/:controller/:action/:params', [
				'controller' => 1,
				'action' => 2,
				'params' => 3
			])
			->setName('oauth-action');

		/**
		 * Add all App\Modules\Oauth specific routes here
		 */
	}
}
