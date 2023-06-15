<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $companiesCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('companies.php');
return call_user_func(function(){

	$companiesCollection = new \Phalcon\Mvc\Micro\Collection();
	$companiesCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/companies')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Backend\Controllers\CompaniesController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$companiesCollection->options('/', 'optionsBase');
	$companiesCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /companies/
	// Second paramter is the function name of the Controller.
	$companiesCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$companiesCollection->head('/', 'get');
	
	$companiesCollection->post('/search', 'search');
	$companiesCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'searchOne');
	
	// $id will be passed as a parameter to the Controller's specified function
	$companiesCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'getOne');
	$companiesCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	$companiesCollection->post('/', 'post');
	$companiesCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'delete');
	$companiesCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'put');
	
	$companiesCollection->put('/upload/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'upload');
	
	return $companiesCollection;
});