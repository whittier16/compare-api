<?php

namespace ComparisonAPI\Test;

use \Phalcon\DI,
	\Phalcon\Loader,
	ComparisonAPI\Test\Helper\UnitTestCase;

/**
 * Test class for ComparisonAPI Application class
 */
class ApplicationTest extends UnitTestCase
{
	/**
	 * Test application instance matches the app service
	 *
	 * @covers \App\Common\Lib\Application\Application::__construct
	 */
	public function testInternalApplicationService()
	{
		$this->assertEquals($this->application, $this->application->di->get('app'));
	}

	/**
	 * Test service registration
	 *
	 * @covers \App\Common\Lib\Application\Application::_registerServices
	 */
	public function testServiceRegistration()
	{
		$this->assertInstanceOf('\Phalcon\Mvc\Router', $this->application->di->get('router'));
		$this->assertInstanceOf('\Phalcon\Session\Adapter', $this->application->di->get('session'));
		$this->assertInstanceOf('\Phalcon\Mvc\Model\MetaData', $this->application->di->get('modelsMetadata'));
		$this->assertInstanceOf('\Phalcon\Annotations\Adapter', $this->application->di->get('annotations'));
		$this->assertInstanceOf('\Phalcon\Events\Manager', $this->application->getEventsManager());
	}

	/**
	 * Simple test for registerModules method
	 *
	 * @covers \App\Common\Lib\Application\Application::registerModules
	 */
	public function testModuleIsRegistered()
	{
		$this->assertArrayHasKey('backend', $this->application->getModules());
	}

	/**
	 * Test applicaton HMVC request
	 *
	 * @covers \App\Common\Lib\Application\Application::request
	 */
	public function testHMVCApplicationRequest()
	{
		$controllerName = 'index';
		$indexCntrl = $this->getController($controllerName);

        $this->assertInstanceOf(
        	'\Phalcon\Mvc\Controller',
        	$indexCntrl,
        	sprintf('Make sure the %sController matches the internal HMVC request.', ucfirst($controllerName))
        );

		$this->assertEquals(
			$indexCntrl->indexAction(),
			$this->application->request([
				'namespace' => 'App\Modules\Backend\Controllers\API',
				'module' => 'backend',
				'controller' => $controllerName,
				'action' => 'index'
			]),
			sprintf(
				'Assert that calling the %s action of the %sController matches the internal HMVC request.',
				$controllerName,
				ucfirst($controllerName)
			)
		);
	}

	/**
	 * Helper to load the a controller
	 *
	 * @coversNothing
	 */
	public function getController($name)
	{
		$loader = new Loader();
		$loader->registerClasses([
			'\App\Modules\Backend\Controllers\API\\' . ucfirst($name) . 'Controller' => ROOT_PATH . 'modules/backend/controller/api/'
		])->register();

		$indexCntrl = new \App\Modules\Backend\Controllers\API\IndexController();
		$this->assertNotNull($indexCntrl, 'Make sure the index controller could be loaded');

		return $indexCntrl;
	}
}
