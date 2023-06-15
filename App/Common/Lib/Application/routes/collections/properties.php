<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $propertiesCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $propertiesCollection = include('properties.php');
return call_user_func(function(){

	$propertiesCollection = new \Phalcon\Mvc\Micro\Collection();
	$propertiesCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/properties')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Backend\Controllers\PropertiesController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$propertiesCollection->options('/', 'optionsBase');
	$propertiesCollection->options('/{title}', 'optionsOne');
	
	// $title will be passed as a parameter to the Controller's specified function
	$propertiesCollection->get('/{title:[a-zA-Z]+}', 'getOne');
	$propertiesCollection->head('/{title:[a-zA-Z]+}', 'getOne');
	
	return $propertiesCollection;
});