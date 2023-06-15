<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $productsOptionsCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('products_options.php');
return call_user_func(function(){

	$productsOptionsCollection = new \Phalcon\Mvc\Micro\Collection();
	$productsOptionsCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/products_options')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Backend\Controllers\ProductsOptionsController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$productsOptionsCollection->options('/', 'optionsBase');
	$productsOptionsCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /products_options/
	// Second paramter is the function name of the Controller.
	$productsOptionsCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$productsOptionsCollection->head('/', 'get');

	// $id will be passed as a parameter to the Controller's specified function
	$productsOptionsCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	$productsOptionsCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	
	$productsOptionsCollection->post('/', 'post');
	
	$productsOptionsCollection->post('/search', 'search');
	$productsOptionsCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'searchOne');
	
	$productsOptionsCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'delete');
	$productsOptionsCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'put');
	
	$productsOptionsCollection->put('/upload/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'upload');
	
	$productsOptionsCollection->put('/import', 'bulkImport');
	

	return $productsOptionsCollection;
});