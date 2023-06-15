<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $areasCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('areas.php');
return call_user_func(function(){

	$areasCollection = new \Phalcon\Mvc\Micro\Collection();
	$areasCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/areas')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Backend\Controllers\AreasController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$areasCollection->options('/', 'optionsBase');
	$areasCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /areas/
	// Second paramter is the function name of the Controller.
	$areasCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$areasCollection->head('/', 'get');
	
	$areasCollection->post('/search', 'search');
	$areasCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'searchOne');
	
	// $id will be passed as a parameter to the Controller's specified function
	$areasCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	$areasCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	$areasCollection->post('/', 'post');
	$areasCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'delete');
	$areasCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'put');

	return $areasCollection;
});