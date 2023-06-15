<?php

namespace App\Modules\Admin\Controllers\API;

use \App\Modules\Admin\Controllers\ModuleApiController;

/**
 * Concrete implementation of Admin module controller
 *
 * @RoutePrefix("/admin/api")
 */
class IndexController extends ModuleApiController
{
	/**
     * @Route("/index", paths={module="admin"}, methods={"GET"}, name="admin-index-index")
     */
    public function indexAction()
    {

    }
}
