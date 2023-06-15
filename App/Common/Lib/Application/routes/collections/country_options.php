<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $countryOptionsCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('country_options.php');
return call_user_func(function(){

	$countryOptionsCollection = new \Phalcon\Mvc\Micro\Collection();
	$countryOptionsCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/country_options')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Backend\Controllers\CountryOptionsController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$countryOptionsCollection->options('/', 'optionsBase');
	$countryOptionsCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /country_options/
	// Second paramter is the function name of the Controller.
	$countryOptionsCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$countryOptionsCollection->head('/', 'get');

	// $id will be passed as a parameter to the Controller's specified function
	$countryOptionsCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'getOne');
	$countryOptionsCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	
	$countryOptionsCollection->post('/', 'post');
	
	$countryOptionsCollection->post('/search', 'search');
	$countryOptionsCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'searchOne');
	
	$countryOptionsCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'delete');
	$countryOptionsCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'put');

	return $countryOptionsCollection;
});