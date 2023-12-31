<?php
namespace  App\Common\Lib\Application\Libraries\Filterus\Filters;

use App\Common\Lib\Application\Libraries\Filterus\Filter;

defined('PHP_INT_MIN') or define('PHP_INT_MIN', ~PHP_INT_MAX);

class Int extends Filter {
    
    protected $defaultOptions = array(
        'min' => PHP_INT_MIN,
        'max' => PHP_INT_MAX,
    );

    public function filter($var) {
        if (!is_numeric($var)) {
            return null;
        }
        $var = (int) $var;
        if ($this->options['min'] > $var) {
            return $this->options['min'];
        } elseif ($this->options['max'] < $var) {
            return $this->options['max'];
        }
        return $var;
    }

    public function validate($var) {
        if (!is_numeric($var)) {
            return false;
        }
        return parent::validate($var);
    }
}