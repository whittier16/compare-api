<?php

namespace App\Modules\Frontend;

use \Phalcon\Loader,
	\Phalcon\DI,
	\Phalcon\Mvc\View,
	\Phalcon\Mvc\Dispatcher,
	\Phalcon\Config,
	\Phalcon\DiInterface,
	\Phalcon\Mvc\Url as UrlResolver,
	\Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
	\App\Common\Lib\Application\Controllers\BaseController,
	\App\Common\Lib\Application\ApplicationModule;

/**
 * Application module definition for multi module application
 * Defining the Frontend module 
 */
class Module extends ApplicationModule
{
	/**
	 * Mount the module specific routes before the module is loaded.
	 * Add ModuleRoutes Group and annotated controllers for parsing their routing information.
	 *
	 * @param \Phalcon\DiInterface  $di
	 */
	public static function initRoutes(DiInterface $di)
	{
		$loader = new Loader();
		$loader->registerNamespaces([
			'App\Modules\Frontend' => __DIR__,
			'App\Modules\Frontend\Controllers' => __DIR__ . '/controllers/',
			'App\Modules\Frontend\Controllers\API' => __DIR__ . '/controllers/api/'
			], true)
			->register();
	}

	/**
	 * Registers the module auto-loader
	 */
	public function registerAutoloaders()
	{
		$loader = new Loader();
		$loader->registerNamespaces([
				'App\Modules\Frontend' => __DIR__,
				'App\Modules\Frontend\Controllers' => __DIR__ . '/controllers/',
				'App\Modules\Frontend\Controllers\API' => __DIR__ . '/controllers/api/',
				'App\Modules\Frontend\Models' => __DIR__ . '/models/',
				'App\Modules\Frontend\Library' => __DIR__ . '/lib/',
			], true)
			->register();
	}
	
	/**
	 * Registers the module-only services
	 *
	 * @param \Phalcon\DiInterface $di
	 */
	public function registerServices($di)
	{
		/**
		 * Read application wide and module only configurations
		 */
		$appConfig = $di->get('config');
		$moduleConfig = include __DIR__ . '/config/config.php';
		
		$di->set('moduleConfig', $moduleConfig);

		/**
		 * The URL component is used to generate all kind of urls in the application
		 */
		$di->set('url', function () use ($appConfig) {
			$url = new UrlResolver();
			$url->setBaseUri($appConfig->application->baseUri);
			return $url;
		});

		/**
		 * Module specific dispatcher
		 */
		$di->set('dispatcher', function () use ($di) {
        	$dispatcher = new Dispatcher();
	        $dispatcher->setEventsManager($di->getShared('eventsManager'));
			$dispatcher->setDefaultNamespace('App\Modules\Frontend\\');
			return $dispatcher;
		});
		
		$di->setShared('request', function () use ($appConfig) {
			return new \Phalcon\Http\Request();
		});
		
		/**
		 * Include config per environment
		 */
		include __DIR__ . '/config/config_' . $appConfig->application->environment . '.php';
		
		$database = $di->getConfig()->application->site . $di->get('request')->getQuery("country_code");

		/**
		 * Simple database connection to localhost
		 */
		$di->setShared('mongo', function($config, $database) {
			$mongo = new \Mongo();
			return $mongo->selectDb($config->$database->dbname);
		}, true);
		
		$di->setShared('collectionManager', function(){
			return new \Phalcon\Mvc\Collection\Manager();
		}, true);
			
	}
}
