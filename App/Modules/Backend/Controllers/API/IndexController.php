<?php

namespace App\Modules\Backend\Controllers\API;

use \App\Modules\Backend\Controllers\ModuleApiController;

/**
 * Concrete implementation of Backend module controller
 *
 * @RoutePrefix("/backend/api")
 */
class IndexController extends ModuleApiController
{
	/**
     * @Route("/index", paths={module="backend"}, methods={"GET"}, name="backend-index-index")
     */
    public function indexAction()
    {

    }
}
