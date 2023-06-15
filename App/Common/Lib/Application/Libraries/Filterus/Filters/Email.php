<?php
namespace  App\Common\Lib\Application\Libraries\Filterus\Filters;

use App\Common\Lib\Application\Libraries\Filterus\Filter;

class Email extends Filter {
    
    public function filter($var) {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

}