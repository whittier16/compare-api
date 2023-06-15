<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $productsCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('products.php');
return call_user_func(function(){

	$productsCollection = new \Phalcon\Mvc\Micro\Collection();
	$productsCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/products')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Backend\Controllers\ProductsController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$productsCollection->options('/', 'optionsBase');
	$productsCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /products/
	// Second paramter is the function name of the Controller.
	$productsCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$productsCollection->head('/', 'get');

	// $id will be passed as a parameter to the Controller's specified function
	$productsCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	$productsCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	
	$productsCollection->post('/', 'post');
	
	$productsCollection->post('/search', 'search');
	$productsCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'searchOne');
	$productsCollection->post('/import', 'bulkImport');
	
	$productsCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'delete');
	$productsCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'put');
	
	$productsCollection->put('/upload/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'upload');
	
	return $productsCollection;
});