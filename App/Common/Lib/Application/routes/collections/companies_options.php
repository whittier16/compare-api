<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $companiesOptionsCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('companies_options.php');
return call_user_func(function(){

	$companiesOptionsCollection = new \Phalcon\Mvc\Micro\Collection();
	$companiesOptionsCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/companies_options')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Backend\Controllers\CompaniesOptionsController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$companiesOptionsCollection->options('/', 'optionsBase');
	$companiesOptionsCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /companies_options/
	// Second paramter is the function name of the Controller.
	$companiesOptionsCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$companiesOptionsCollection->head('/', 'get');

	// $id will be passed as a parameter to the Controller's specified function
	$companiesOptionsCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'getOne');
	$companiesOptionsCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	
	$companiesOptionsCollection->post('/', 'post');
	
	$companiesOptionsCollection->post('/search', 'search');
	$companiesOptionsCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'searchOne');
	
	$companiesOptionsCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'delete');
	$companiesOptionsCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'put');

	return $companiesOptionsCollection;
});