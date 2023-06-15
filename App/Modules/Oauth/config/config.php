<?php

return new \Phalcon\Config([
	'database' => [
		'adapter' => 'Mysql',
		'host' => 'localhost',
		'username' => 'root',
		'password' => 'root',
		'dbname' => 'compare_oauth',
		'persistent' => true,
		'charset' => 'utf8'
	],

	'controllers' => [
		'annotationRouted' => [
			'\App\Modules\Oauth\Controllers\API\Index',
		]
	]
]);
