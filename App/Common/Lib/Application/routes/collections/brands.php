<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $brandCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('brands.php');
return call_user_func(function(){

	$brandCollection = new \Phalcon\Mvc\Micro\Collection();
	$brandCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/brands')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Backend\Controllers\BrandsController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$brandCollection->options('/', 'optionsBase');
	$brandCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /brands/
	// Second paramter is the function name of the Controller.
	$brandCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$brandCollection->head('/', 'get');
	
	$brandCollection->post('/search', 'search');
	$brandCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'searchOne');
	
	// $id will be passed as a parameter to the Controller's specified function
	$brandCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	$brandCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	$brandCollection->post('/', 'post');
	$brandCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'delete');
	$brandCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'put');
	
	$brandCollection->put('/upload/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'upload');
	
	return $brandCollection;
});