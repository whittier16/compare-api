<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $channelsOptionsCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('channels_options.php');
return call_user_func(function(){

	$channelsOptionsCollection = new \Phalcon\Mvc\Micro\Collection();
	$channelsOptionsCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/channels_options')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Backend\Controllers\ChannelsOptionsController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$channelsOptionsCollection->options('/', 'optionsBase');
	$channelsOptionsCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /channels_options/
	// Second paramter is the function name of the Controller.
	$channelsOptionsCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$channelsOptionsCollection->head('/', 'get');

	// $id will be passed as a parameter to the Controller's specified function
	$channelsOptionsCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'getOne');
	$channelsOptionsCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	
	$channelsOptionsCollection->post('/', 'post');
	
	$channelsOptionsCollection->post('/search', 'search');
	$channelsOptionsCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'searchOne');
	
	$channelsOptionsCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'delete');
	$channelsOptionsCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'put');

	return $channelsOptionsCollection;
});