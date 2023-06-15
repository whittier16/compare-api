<?php
namespace  App\Common\Lib\Application\Libraries\Filterus\Filters;

use App\Common\Lib\Application\Libraries\Filterus\Filter;

class Raw extends Filter {
    
    public function filter($var) {
        return $var;
    }
}