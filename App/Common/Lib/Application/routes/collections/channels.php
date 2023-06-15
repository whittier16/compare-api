<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $channelsCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('channels.php');
return call_user_func(function(){

	$channelsCollection = new \Phalcon\Mvc\Micro\Collection();
	$channelsCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/channels')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Backend\Controllers\ChannelsController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$channelsCollection->options('/', 'optionsBase');
	$channelsCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /channels/
	// Second paramter is the function name of the Controller.
	$channelsCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$channelsCollection->head('/', 'get');
	
	$channelsCollection->post('/search', 'search');
	$channelsCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'searchOne');
	
	// $id will be passed as a parameter to the Controller's specified function
	$channelsCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	$channelsCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'getOne');
	$channelsCollection->post('/', 'post');
	$channelsCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'delete');
	$channelsCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp .'+}', 'put');

	return $channelsCollection;
});