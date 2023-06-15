<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $adminGroupsCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('admin_groups.php');
return call_user_func(function(){
	$adminGroupsCollection = new \Phalcon\Mvc\Micro\Collection();
	$adminGroupsCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/'. $this->di->getConfig()->application->version . '/admin/groups')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Admin\Controllers\GroupsController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$adminGroupsCollection->options('/', 'optionsBase');
	$adminGroupsCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /groups/
	// Second paramter is the function name of the Controller.
	$adminGroupsCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$adminGroupsCollection->head('/', 'get');
	
	$adminGroupsCollection->post('/search', 'search');
	$adminGroupsCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'searchOne');
	
	// $id will be passed as a parameter to the Controller's specified function
	$adminGroupsCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	$adminGroupsCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	$adminGroupsCollection->post('/', 'post');
	$adminGroupsCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'delete');
	$adminGroupsCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'put');

	return $adminGroupsCollection;
});