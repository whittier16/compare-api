<?php

namespace App\Modules\Backend\Test;

use Phalcon\DI,
	App\Modules\Backend\Test\Helper\ModuleUnitTestCase;

/**
 * Test class for Backend Module class
 */
class ModuleTest extends ModuleUnitTestCase
{
	/**
	 * Test class for module routes
	 * @covers \App\Modules\Backend\Module::initRoutes
	 */
	public function testSimpleModuleRoute()
	{
		$di = $this->application->di;
		$router = $di->get('router');
	    $router->handle('/');
	    $this->assertEquals('backend', $router->getModuleName());
	    $this->assertEquals('index', $router->getControllerName());
	    $this->assertEquals('index', $router->getActionName());
	}

	/**
	 * Test url generation
	 *
	 * @covers \App\Modules\Backend\Module::registerServices
	 */
	public function testServiceRegistration()
	{
		$this->assertInstanceOf('\Phalcon\Config', $this->application->di->get('moduleConfig'));
		$this->assertInstanceOf('\Phalcon\Mvc\View', $this->application->di->get('view'));
		$this->assertInstanceOf('\Phalcon\Mvc\Url', $this->application->di->get('url'));
		$this->assertInstanceOf('\Phalcon\Mvc\Dispatcher', $this->application->di->get('dispatcher'));
		$this->assertInstanceOf('\Phalcon\Db\AdapterInterface', $this->application->di->get('db'));
	}
}
