<?php
namespace  App\Common\Lib\Application\Libraries\Filterus\Filters;

use App\Common\Lib\Application\Libraries\Filterus\Filter;

class Chain extends Filter {
    
    protected $defaultOptions = array(
        'filters' => array(),
    );

    public function filter($var) {
        foreach ($this->options['filters'] as $filter) {
            $filter = self::factory($filter);
            $var = $filter->filter($var);
        }
        return $var;
    }

    public function validate($var) {
        foreach ($this->options['filters'] as $filter) {
            $filter = self::factory($filter);
            if (!$filter->validate($var)) {
                return false;
            }
            $var = $filter->filter($var);
        }
        return true;
    }

}