<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $verticalsCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('verticals.php');
return call_user_func(function(){

	$verticalsCollection = new \Phalcon\Mvc\Micro\Collection();
	$verticalsCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/verticals')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Backend\Controllers\VerticalsController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$verticalsCollection->options('/', 'optionsBase');
	$verticalsCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /verticals/
	// Second paramter is the function name of the Controller.
	$verticalsCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$verticalsCollection->head('/', 'get');
	
	$verticalsCollection->post('/search', 'searches');
	$verticalsCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'searchOne');
	
	// $id will be passed as a parameter to the Controller's specified function
	$verticalsCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	$verticalsCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'getOne');
	$verticalsCollection->post('/', 'post');
	$verticalsCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'delete');
	$verticalsCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'put');

	return $verticalsCollection;
});