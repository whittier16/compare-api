<?php

namespace App\Common\Lib\Application;

use \Phalcon\Mvc\ModuleDefinitionInterface,
    \Phalcon\Mvc\User\Module as UserModule,
    \App\Common\Lib\Application\RoutedModule;

/**
 * Abstract application module base class
 */
abstract class ApplicationModule
    extends UserModule
    implements ModuleDefinitionInterface, RoutedModule
{

}
