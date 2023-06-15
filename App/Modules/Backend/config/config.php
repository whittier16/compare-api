<?php

$config = new \Phalcon\Config([
	'database' => [
		'adapter' => 'Mysql',
		'host' => 'localhost',
		'username' => 'root',
		'password' => 'root',
		'dbname' => 'penge_dk_live',
		'persistent' => true,
		'charset' => 'utf8'
		],
	'controllers' => [
		'annotationRouted' => [
			'\App\Modules\Backend\Controllers\API\Index',
		]
	]
]);
