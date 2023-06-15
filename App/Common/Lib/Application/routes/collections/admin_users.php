<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $adminUsersCollection
 */

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('admin_users.php');
return call_user_func(function(){

	$adminUsersCollection = new \Phalcon\Mvc\Micro\Collection();
	$adminUsersCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/' . $this->di->getConfig()->application->version . '/admin/users')
		// Must be a string in order to support lazy loading
		->setHandler('\App\Modules\Admin\Controllers\UsersController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$adminUsersCollection->options('/', 'optionsBase');
	$adminUsersCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /users/
	// Second paramter is the function name of the Controller.
	$adminUsersCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$adminUsersCollection->head('/', 'get');
	
	$adminUsersCollection->post('/search', 'search');
	$adminUsersCollection->post('/search/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'searchOne');
	
	$adminUsersCollection->post('/login', 'login');
	
	// $id will be passed as a parameter to the Controller's specified function
	$adminUsersCollection->get('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'getOne');
	$adminUsersCollection->head('/{id:' . $this->di->getConfig()->application->idRegExp .  '+}', 'getOne');
	$adminUsersCollection->post('/', 'post');
	$adminUsersCollection->delete('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'delete');
	$adminUsersCollection->put('/{id:' . $this->di->getConfig()->application->idRegExp . '+}', 'put');

	return $adminUsersCollection;
});