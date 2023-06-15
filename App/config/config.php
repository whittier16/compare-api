<?php

/**
 * API application configuration
 */

return new \Phalcon\Config([
	'debug' => false,
	'profiler' => false,
	'application' => [
		'baseUri' => '/www2/comparison-api/',
		'annotations' => ['adapter' => 'Apc'],
		'models' => [
			'metadata' => ['adapter' => 'Apc']
		],
		'jsonSchemaDir' => '/../../../config/data/jsonschema/',
		'jsonSchema' =>  [
			'areas' => 'areas.json',
			'channels' => 'channels.json',
			'brands' => 'brands.json',
			'companies' => 'companies.json',
			'credit-card' => 'channels/credit-cards.json',
			'personal-loan' => 'channels/personal-loans.json',
			'home-loans' => 'channels/home-loans.json',
			'broadband' => 'channels/broadbands.json',
		    'car-insurance' => 'channels/car-insurance.json'
		],
		'version' => 'v1', 
		'environment' => 'local',
		'site' => 'compar',
		'uploadPath' => [
			'local' => '/tmp/',
			'development' => '/home/cglobal/public_html/mediadev.compargo.com/',
			'staging' => '/home/cglobal/public_html/mediastage.compargo.com/',
			'production' => '/home/cglobal/public_html/media.compargo.com/',
			],
		'uploadUrl' => [
			'local' => 'http://localhost/',
			'development' => 'http://mediadev.compargo.com/',
			'staging' => 'http://mediastage.compargo.com/',
			'production' => 'http://media.compargo.com/',
			],
		'maxMediaPerUpload' => 1,
		'imageSizeLimit' => 3145728,
		'imageSizes' => [
			'small' => [
				'width' => 200,
				'height' => 200,
				'quality' => 85
			]
		],
		'idRegExp' => "[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}",
		'osFlag' => 1
	],
	'oauth2' => [
		'endPointAuthorize' => 'http://oauth.compargo.com/authorize.php',
		'endPointAccessToken' => 'http://oauth.compargo.com/token.php',
	]
]);
