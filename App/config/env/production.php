<?php

/**
 * Production database configuration
 */

$config = new \Phalcon\Config(
	[
	    'comparph' => [
	        'adapter' => 'mysql',
	        'host' => 'localhost',
	        'username' => 'comparph',
	        'password' => 'nDA-RNX-g5U-cns',
	        'dbname' => 'comparph_prod'
	    ],
		'comparhk' => [
			'adapter' => 'mysql',
			'host' => 'localhost',
			'username' => 'comparhk',
			'password' => 'Y9p-3B6-7WV-zLA',
			'dbname' => 'comparhk_prod'
		],
		'comparmy' => [
			'adapter' => 'mysql',
			'host' => 'localhost',
			'username' => 'comparmy',
			'password' => 'tX6-4mr-efR-hcg',
			'dbname' => 'comparmy_prod'
		],
		'comparth' => [
			'adapter' => 'mysql',
			'host' => 'localhost',
			'username' => 'comparth',
			'password' => 'rMZ-Ebe-tBL-Na7',
			'dbname' => 'comparth_prod'
		],
		'comparid' => [
			'adapter' => 'mysql',
			'host' => 'localhost',
			'username' => 'comparid',
			'password' => 'rMZ-Ebe-tBL-Na7',
			'dbname' => 'comparid_prod'
		],
		'compartw' => [
			'adapter' => 'mysql',
			'host' => 'localhost',
			'username' => 'compartw',
			'password' => 'xk9-Lgc-Lyc-FKx',
			'dbname' => 'compartw_prod'
		],
		'compardk' => [
			'adapter' => 'mysql',
			'host' => 'localhost',
			'username' => 'compardk',
			'password' => 'N8!c8Z&8G9An',
			'dbname' => 'compardk_prod'
		]
	]
);
