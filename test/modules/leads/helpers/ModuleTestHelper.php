<?php
use Phalcon\DI,
    Phalcon\DI\FactoryDefault;

ini_set('display_errors',1);
error_reporting(E_ALL);

define('ROOT_PATH', __DIR__ . '/../../../../');
define('PATH_LIBRARY', __DIR__ . '/common/lib/application/');

set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

/**
 * Use the application autoloader to autoload the required
 * bootstrap and test helper classes
 */
$loader = new \Phalcon\Loader();
$loader->registerNamespaces([
    'Phalcon\Test' => ROOT_PATH . 'test/phalcon/',
    'App\Common\Lib\Application' => ROOT_PATH . 'common/lib/application/',
    'App\Common\Lib\Application\Controllers' => ROOT_PATH . 'common/lib/application/controllers/',
    'ComparisonAPI\Test\Helper' => ROOT_PATH . 'test/helpers/',
    'App\Modules\Leads\Controllers\API' => ROOT_PATH . 'modules/leads/controllers/api/',
    'App\Modules\Leads\Controllers' => ROOT_PATH . 'modules/leads/controllers/',
    'App\Modules\Leads\Test\Helper' => ROOT_PATH . 'test/modules/leads/helpers/',
    'App\Modules\Leads' => ROOT_PATH . 'modules/leads/'
])->register();

$di = new FactoryDefault();
DI::reset();

// add any needed services to the DI here

DI::setDefault($di);
