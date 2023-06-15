<?php
namespace App\Common\Lib\Application\Plugins;

use \Phalcon\Mvc\User\Plugin;

class Utils extends Plugin
{
    public function uuid()
    {
        $result = $this->db->query("SELECT UUID()");
        $arr = $result->fetch();
        return $arr[0];
    }
}