<?php

namespace App\Modules\Oauth;

use \Phalcon\Loader,
	\Phalcon\DI,
	\Phalcon\Mvc\View,
	\Phalcon\Mvc\Dispatcher,
	\Phalcon\Config,
	\Phalcon\DiInterface,
	\Phalcon\Mvc\Url as UrlResolver,
	\Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
	\App\Common\Lib\Application\ApplicationModule;

/**
 * Application module definition for multi module application
 * Defining the Oauth module 
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
			'App\Modules\Oauth' => __DIR__,
			'App\Modules\Oauth\Controllers' => __DIR__ . '/controllers/'
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
				'App\Modules\Oauth' => __DIR__,
				'App\Modules\Oauth\Controllers' => __DIR__ . '/controllers/',
				'App\Modules\Oauth\Models' => __DIR__ . '/models/',
				'App\Modules\Oauth\Library' => __DIR__ . '/lib/',
				'App\Modules\Oauth\Library\Oauth' => __DIR__ . '/lib/OAuth'
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
			$dispatcher->setDefaultNamespace('App\Modules\Oauth\\');
			return $dispatcher;
		});

		/**
		 * Module specific database connection
		 */
		$di->set('db', function() use ($appConfig) {
			return new DbAdapter([
				'host' => $moduleConfig->database->host,
				'username' => $moduleConfig->database->username,
				'password' => $moduleConfig->database->password,
				'dbname' => $moduleConfig->database->name
			]);
		});
	}
}
