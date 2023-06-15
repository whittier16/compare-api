<?php
namespace App\Common\Lib\Application;

use \Phalcon\DiInterface,
	\Phalcon\Loader,
	\Phalcon\Http\ResponseInterface,
	\Phalcon\Events\Manager as EventsManager,
	\App\Common\Lib\Application\Router\ApplicationRouter,
	\App\Common\Lib\Application\Exceptions\HTTPException,
	\App\Common\Lib\Application\Responses\JSONResponse,
	\App\Common\Lib\Application\Responses\XMLResponse,
	\App\Common\Lib\Application\Responses\CSVResponse,
	\App\Modules\Backend\Controllers\SessionsController;

/**
 * Application class for multi module applications
 * including HMVC internal requests.
 */
class Application extends \Phalcon\Mvc\Application
{
	/**
	 * Application Constructor
	 *
	 * @param \Phalcon\DiInterface $di
	 */
	public function __construct(DiInterface $di)
	{
		/**
		 * Sets the parent DI and register the app itself as a service,
		 * necessary for redirecting HMVC requests
		 */
		parent::setDI($di);
		$di->set('app', $this);

		/**
		 * Register application wide accessible services
		 */
		$this->_registerServices();

		/**
		 * Register the installed/configured modules
		 */
		$this->registerModules(require __DIR__ . '/../../../config/modules.php');
	}

	/**
	 * Register the services here to make them general or register in the
	 * ModuleDefinition to make them module-specific
	 */
	protected function _registerServices()
	{	
		/**
		 * The application wide configuration
		 */
		$config = include __DIR__ . '/../../../config/config.php';
		$this->di->set('config', $config);

		/**
		 * Setup an events manager with priorities enabled
		 */
		$eventsManager = new EventsManager();
		$eventsManager->enablePriorities(true);
		$this->setEventsManager($eventsManager);

		/**
		 * Register namespaces for application classes
		 */
		$loader = new Loader();
		$loader->registerNamespaces([
				'App\Common\Lib\Application' => __DIR__,
				'App\Common\Lib\Application\Controllers' => __DIR__ . '/Controllers/',
				'App\Common\Lib\Application\Models' => __DIR__ . '/Models/',
				'App\Common\Lib\Application\Libraries' => __DIR__ . '/Libraries/',
				'App\Common\Lib\Application\Router' => __DIR__ . '/router/',
				'App\Common\Lib\Application\Responses' => __DIR__ . '/Responses/',
				'App\Common\Lib\Application\Exceptions' => __DIR__ . '/Exceptions/'
			], true)
			->register();

		/**
		 * Registering the application wide router with the standard routes set
		 */
		$this->di->set('router', new ApplicationRouter());
		
		/**
		 * Return array of the Collections, which define a group of routes, from
		 * routes/collections.  These will be mounted into the app itself later.
		 */
		$this->di->setShared('collections', function(){
			return include( __DIR__ . '/routes/routeLoader.php');
		});

		/**
		 * Include function helpers
		 */
		include __DIR__ . '/helpers/functionHelper.php';
		include __DIR__ . '/helpers/PasswordHash.php';
			
		/**
		 * Specify the use of metadata adapter
		 */
		$this->di->set('modelsMetadata', '\Phalcon\Mvc\Model\Metadata\\' . $config->application->models->metadata->adapter);

		/**
		 * Specify the annotations cache adapter
		 */
		$this->di->set('annotations', '\Phalcon\Annotations\Adapter\\' . $config->application->annotations->adapter);
	}

	/**
	 * Register the given modules in the parent and prepare to load
	 * the module routes by triggering the init routes method
	 */
	public function registerModules($modules, $merge = null)
	{
		parent::registerModules($modules, $merge);

		$loader = new Loader();
		$modules = $this->getModules();

		/**
		 * Iterate the application modules and register the routes
		 * by calling the initRoutes method of the Module class.
		 * We need to auto load the class 
		 */
		foreach ($modules as $module) {
			$className = $module['className'];
			
			if (!class_exists($className, false)) {
				$loader->registerClasses([ $className => $module['path'] ], true)->register()->autoLoad($className);
			}
			
			/** @var \App\Common\Lib\Application\ApplicationModule $className */
			$className::initRoutes($this->di);
		}
	}
	
	/**
	 * Handles the request.
	 */
	public function main()
	{	
		/**
		 * Our application is a Micro application, so we must explicitly define all the routes.
		 * For APIs, this is ideal.  This is as opposed to the more robust MVC Application
		 * @var $app
		 */
		$app = new \Phalcon\Mvc\Micro();
		$app->setDI($this->di);

		/**
		 * This will require changes to fit your application structure.
		 * It supports Auth, Session auth, and Exempted routes.
		 * It also allows all Options requests, as those tend to not come with
		 * cookies or basic auth credentials and Preflight is not implemented the
		 * same in every browser.
		 */
		$app->before(function() use ($app) {
			// Oauth, for programmatic responses
			if ($app->request->getHeader('X_COMPARE_REST_API_KEY') &&
				$app->request->get('language') && 
				$app->request->get('countryCode')) {
				
				$session = new SessionsController();
				$result = $session->resource($app->request->getHeader('X_COMPARE_REST_API_KEY'));
				if ($result){
					return true;
				}else{
					throw new HTTPException(
						'Invalid access token.',
						401,
						[
							'dev' => 'Please provide credentials by passing your access token.',
							'internalCode' => 'Unauth:1'
						]
					);
				}
			}
			
			// If we made it this far, we have no valid auth method, throw a 401.
			throw new HTTPException(
				'Must provide credentials.',
				401,
				[
					'dev' => 'Please provide credentials by passing your access token, language and country code.',
					'internalCode' => 'Unauth:1'
				]
			);
			
			return false;
		});

		/**
		 * Mount all of the collections, which makes the routes active.
		 */
		foreach($this->di->getShared('collections') as $collection){
			$app->mount($collection);
		}

		/**
		 * The base route return the list of defined routes for the application.
		 * This is not strictly REST compliant, but it helps to base API documentation off of.
		 * By calling this, you can quickly see a list of all routes and their methods.
		 */
		$app->get('/', function() use ($app){
			$routes = $app->getRouter()->getRoutes();
			$routeDefinitions = array('GET'=>array(), 'POST'=>array(), 'PUT'=>array(), 'PATCH'=>array(), 'DELETE'=>array(), 'HEAD'=>array(), 'OPTIONS'=>array());
			foreach($routes as $route){
				$method = $route->getHttpMethods();
				$routeDefinitions[$method][] = $route->getPattern();
			}
			return $routeDefinitions;
		});

		/**
		 * After a route is run, usually when its Controller returns a final value,
		 * the application runs the following function which actually sends the response to the client.
		 *
		 * The default behavior is to send the Controller's returned value to the client as JSON.
		 * However, by parsing the request querystring's 'type' paramter, it is easy to install
		 * different response type handlers.  Below is an alternate csv handler.
		*/
		$app->after(function() use ($app) {
				
			// OPTIONS have no body, send the headers, exit
			if ($app->request->getMethod() == 'OPTIONS'){
				$app->response->setStatusCode('200', 'OK');
				$app->response->send();
				return;
			}
				
			// Respond by default as JSON
			if (!$app->request->get('type') || 'json' == $app->request->get('type') || 'option' == $app->request->get('type')) {
				// Results returned from the route's controller.  All Controllers should return an array
				$records = $app->getReturnedValue();
				$response = new JSONResponse();
				$response->useEnvelope(true) //this is default behavior
				->convertSnakeCase(true) //this is also default behavior
				->send($records);
				return;
			} else if ('xml' == $app->request->get('type')) {
				$records = $app->getReturnedValue();
				$response = new XMLResponse();
				$response->send($records);
				return;
			} else if ('csv' == $app->request->get('type')) {
				$records = $app->getReturnedValue();
				$response = new CSVResponse();
				$response->useHeaderRow(true)->send($records);
				return;
			} else {
				throw new HTTPException(
					'Could not return results in specified format',
					403,
					array(
						'dev' => 'Could not understand type specified by type paramter in query string.',
						'internalCode' => 'NF1000',
						'more' => 'Type may not be implemented. Choose either "json", "xml" or "csv"'
					)
				);
			}
		});
				
		/**
		 * The notFound service is the default handler function that runs when no route was matched.
		 * We set a 404 here unless there's a suppress error codes.
		 */
		$app->notFound(function () use ($app) {
			throw new HTTPException(
				'Not Found.',
				404,
				array(
					'dev' => 'That route was not found on the server.',
					'internalCode' => 'NF1000',
					'more' => 'Check route for mispellings.'
				)
			);
		});

		/**
		 * If the application throws an HTTPException, send it on to the client as json.
		 * Elsewise, just log it.
		 */
		set_exception_handler(function($exception) use ($app){
			//HTTPException's send method provides the correct response headers and body
			if (is_a($exception, 'App\\Common\\Lib\\Application\\Exceptions\\HTTPException')){
				$exception->send();
			}
			error_log($exception);
			error_log($exception->getTraceAsString());
		});
						
		$app->handle();
	}

	/**
	  * Does a HMVC request inside the application
	  *
	  * Inside a controller we might do
	  * <code>
	  * $this->app->request([ 'controller' => 'do', 'action' => 'something' ], 'param');
	  * </code>
	  *
	  * @param array $location Array with the route information: 'namespace', 'module', 'controller', 'action', 'params'
	  * @return mixed
	  */
	public function request(array $location)
	{
		/** @var \Phalcon\Mvc\Dispatcher $dispatcher */
		$dispatcher = clone $this->di->get('dispatcher');

		if (isset($location['module'])) {
			$dispatcher->setModuleName($location['module']);
		}

		if (isset($location['namespace'])) {
			$dispatcher->setNamespaceName($location['namespace']);
		}

		if (!isset($location['controller'])) {
			$location['controller'] = 'index';
		}

		if (!isset($location['action'])) {
			$location['action'] = 'index';
		}

		if (!isset($location['params'])) {
			$location['params'] = [];
		}

		$dispatcher->setControllerName($location['controller']);        	
		$dispatcher->setActionName($location['action']);
		$dispatcher->setParams((array) $location['params']);
		$dispatcher->dispatch();

		$response = $dispatcher->getReturnedValue();
		
		if ($response instanceof ResponseInterface) {
			return $response->getContent();
		}
        
		return $response;
	}
}
