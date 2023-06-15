<?php
/**
 * Change error reporting level for production use
 */
error_reporting(E_ALL);

use Phalcon\DI\FactoryDefault;

require __DIR__ . '/../App/Common/Lib/Application/Application.php';

/**
 * Instantiate the Application class to do the bootstrapping
 */

$application = new App\Common\Lib\Application\Application(new FactoryDefault());
$application->main();