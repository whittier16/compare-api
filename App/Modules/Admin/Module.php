<?php

namespace App\Modules\Admin;

use \Phalcon\Loader,
	\Phalcon\Mvc\Dispatcher,
	\Phalcon\DiInterface,
	\Phalcon\Mvc\Url as UrlResolver,
	\Phalcon\Events\Manager as EventsManager,
	\Phalcon\Logger\Adapter\File as FileLogger,
	\App\Common\Lib\Application\Plugins\Utils,
	\App\Common\Lib\Application\ApplicationModule,
    \App\Common\Lib\Application\Exceptions\HTTPException;

/**
 * Application module definition for multi module application
 * Defining the Admin module 
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
			'App\Modules\Admin' => __DIR__,
			'App\Modules\Admin\Models' => __DIR__ . '/Models/',
			'App\Modules\Admin\Controllers' => __DIR__ . '/Controllers/',
			'App\Modules\Admin\Controllers\API' => __DIR__ . '/Controllers/api/'
			], TRUE)
			->register();
		
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
		
		$di->setShared('request', function () use ($appConfig) {
			return new \Phalcon\Http\Request();
		});
			
		/**
		 * Read configuration
		 */
		include __DIR__ . "/../../config/env/" . $appConfig->application->environment . ".php";

		$database = $di->getConfig()->application->site . $di->get('request')->getQuery("countryCode");

		/**
		 * Module specific database connection
		 */
		$di->set('dbMysql', function() use ($config, $database) {
			
			$eventsManager = new \Phalcon\Events\Manager();
			
			$logger = new FileLogger(__DIR__ . "/../../Common/logs/admin/debug.log");
			
			//Listen all the database events
			$eventsManager->attach('dbMysql', function($event, $connection) use ($logger) {
				if ($event->getType() == 'beforeQuery') {
					$logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
				}
			});
			
			$connection = new \Phalcon\Db\Adapter\Pdo\Mysql([
				'host' => $config->$database->host,
				'username' => $config->$database->username,
				'password' => $config->$database->password,
				'dbname' => $config->$database->dbname,
				'options' => array(
					\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
				)
			]);
			
			//Assign the eventsManager to the db adapter instance
			$connection->setEventsManager($eventsManager);
			
			return $connection;
		});
		
		/**
		 * Module specific dispatcher
		 */
		$di->setShared('dispatcher', function () use ($di) {
			$dispatcher = new Dispatcher();
			$dispatcher->setDefaultNamespace('App\Modules\Admin\Controllers\\');
			return $dispatcher;
		});
		
		$di->set('utils',function(){
			require __DIR__ . "/../../Common/Lib/Application/Plugins/Utils.php";
			$utils = new Utils();
			return $utils;
		});
			
		/**
		 * If our request contains a body, it has to be valid JSON.  This parses the
		 * body into a standard Object and makes that available from the DI.  If this service
		 * is called from a function, and the request body is not valid JSON or is empty,
		 * the program will throw an Exception.
		 */
		$di->setShared('requestBody', function() {
			parse_str(file_get_contents("php://input"), $in);
			// JSON body could not be parsed, throw exception
			if ($in === null){
				throw new HTTPException(
					'There was a problem understanding the data sent to the server by the application.',
					409,
					array(
						'dev' => 'The JSON body sent to the server was unable to be parsed.',
						'internalCode' => 'REQ1000',
						'more' => ''
					)
				);
			}
		
			return $in;
		});
	}

	/**
	 * Registers the module auto-loader
	 */
	public function registerAutoloaders()
	{
		$loader = new Loader();
		$loader->registerNamespaces([
				'App\Modules\Admin' => __DIR__,
				'App\Modules\Admin\Controllers' => __DIR__ . '/controllers/',
				'App\Modules\Admin\Controllers\API' => __DIR__ . '/controllers/api/',
				'App\Modules\Admin\Models' => __DIR__ . '/models/',
				'App\Modules\Admin\Library' => __DIR__ . '/lib/'
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

		$di->setShared('moduleConfig', $moduleConfig);

		/**
		 * The URL component is used to generate all kind of urls in the application
		 */
		$di->set('url', function () use ($appConfig) {
			$url = new UrlResolver();
			$url->setBaseUri($appConfig->application->baseUri);
			return $url;
		});
	}
}
