<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $countryCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('country.php');
return call_user_func(function(){

	$countryCollection = new \Phalcon\Mvc\Micro\Collection();
	$countryCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/country')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Backend\Controllers\CountryController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$countryCollection->options('/', 'optionsBase');
	$countryCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /country/
	// Second paramter is the function name of the Controller.
	$countryCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$countryCollection->head('/', 'get');
	
	$countryCollection->post('/search', 'search');
	$countryCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'searchOne');
	
	// $id will be passed as a parameter to the Controller's specified function
	$countryCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	$countryCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'getOne');
	$countryCollection->post('/', 'post');
	$countryCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'delete');
	$countryCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'put');

	return $countryCollection;
});