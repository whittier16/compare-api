<?php
namespace App\Modules\Backend;

use \Phalcon\Loader,
	\Phalcon\Mvc\Dispatcher,
	\Phalcon\DiInterface,
	\Phalcon\Mvc\Model,
	\Phalcon\Events\Event,
	\Phalcon\Mvc\Url as UrlResolver,
	\App\Modules\Backend\Library\MyDBListener,
	\App\Modules\Backend\Library\CustomModelsManager,
	\App\Common\Lib\Application\Plugins\Utils,
	\App\Common\Lib\Application\ApplicationModule,
    \App\Common\Lib\Application\Exceptions\HTTPException;
	

/**
 * Application module definition for multi module application
 * Defining the Backend module 
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
				'App\Modules\Backend\Controllers' => __DIR__ . '/Controllers/',
				'App\Modules\Backend\Controllers\API' => __DIR__ . '/Controllers/api/',
				'App\Modules\Backend\Models' => __DIR__ . '/Models/',
				'App\Modules\Backend\Library' => __DIR__ . '/Lib/',
				'App\Modules\Frontend\Controllers' => __DIR__ . '/../Frontend/Controllers/',
				'App\Modules\Frontend\Models' => __DIR__ . '/../Frontend/Models/'
			], TRUE)
		->register();
		
		/**
		 * Read application wide and module only configurations
		 */
		$appConfig = $di->get('config');
		
		$moduleConfig = include __DIR__ . '/config/config.php';
		
		$di->setShared('moduleConfig', $moduleConfig);
		
		/**
		 * The URL component is used to generate all kind of urls in the application
		 */
		$di->setShared('url', function () use ($appConfig) {
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
		$di->set('db', function() use ($config, $database) {
			
			$eventsManager = new \Phalcon\Events\Manager();
				
			//Create a database listener
			$dbListener = new MyDBListener();
			
			//Listen all the database events
			$eventsManager->attach('db', $dbListener);
					
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
		 * Simple database connection to localhost
		 */
		$di->set('mongo', function() use ($config, $database) {
			$mongo = new \MongoClient();
			return $mongo->selectDb($config->$database->dbname);
		}, true);
		
		$di->set('collectionManager', function(){
			return new \Phalcon\Mvc\Collection\Manager();
		}, true);
		
		/**
		 * Include composer autoloader
		 */
		require __DIR__ . "/../../../vendor/autoload.php";
		
		/**
		 * Module specific dispatcher
		 */
		$di->set('dispatcher', function () use ($di) {
			$dispatcher = new Dispatcher();
			$dispatcher->setDefaultNamespace('App\Modules\Backend\Controllers\\');
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
		
		/**
		 * This means we can create listeners that run when an event is triggered.
		 */
		$di->setShared('modelsManager', function() use ($di, $config, $database) {
				
			$eventsManager = new \Phalcon\Events\Manager();
				
			$customModelsManager = new CustomModelsManager();
			
			/**
			 * Attach an anonymous function as a listener for "model" events
			 */
			$eventsManager->attach('model', $customModelsManager);
					
			/**
			 * Setting a default EventsManager
			 */
			$customModelsManager->setEventsManager($eventsManager);
			
			return $customModelsManager;
		});
		
	}	

	/**
	 * Registers the module auto-loader
	 */
	public function registerAutoloaders()
	{
		$loader = new Loader();
		$loader->registerNamespaces([
				'App\Modules\Backend' => __DIR__,
				'App\Modules\Backend\Controllers' => __DIR__ . '/controllers/',
				'App\Modules\Backend\Controllers\API' => __DIR__ . '/controllers/api/',
				'App\Modules\Backend\Models' => __DIR__ . '/models/',
				'App\Modules\Backend\Library' => __DIR__ . '/lib/'
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
