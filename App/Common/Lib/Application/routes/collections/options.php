<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $attributesCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('attributes.php');
return call_user_func(function(){

	$attributesCollection = new \Phalcon\Mvc\Micro\Collection();
	$attributesCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/attributes')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Backend\Controllers\AttributesController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$attributesCollection->options('/', 'optionsBase');
	$attributesCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /attributes/
	// Second paramter is the function name of the Controller.
	$attributesCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$attributesCollection->head('/', 'get');

	// $id will be passed as a parameter to the Controller's specified function
	$attributesCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'getOne');
	$attributesCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	
	$attributesCollection->post('/', 'post');
	
	$attributesCollection->post('/search', 'searches');
	$attributesCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'searchOne');
	
	$attributesCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'delete');
	$attributesCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'put');

	return $attributesCollection;
});