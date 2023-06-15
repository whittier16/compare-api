<?php
namespace  App\Common\Lib\Application\Libraries\Filterus\Filters;

use App\Common\Lib\Application\Libraries\Filterus\Filter;

class String extends Filter {
    
    protected $defaultOptions = array(
        'min' => 0,
        'max' => PHP_INT_MAX,
    );

    public function filter($var) {

        $retVal = (string) preg_match("/([a-zA-Z].*)/", $var) ? "TRUE" : "FALSE";
        if ( $retVal === "FALSE" ) 
            { 
                // echo 'false;'; //die;
                return null;
            } else {
                // echo 'true;'; //die;
            }


        if (is_object($var) && method_exists($var, '__toString')) {
            $var = (string) $var;
        }
        if (!is_scalar($var)) {
            return null;
        }
        $var = (string) $var;
        if ($this->options['min'] > strlen($var)) {
            return null;
        } elseif ($this->options['max'] < strlen($var)) {
            return null;
        }
        return $var;
    }

    public function validate($var) {
        if (is_object($var) && method_exists($var, '__toString')) {
            $var = (string) $var;
        }
        return parent::validate($var);
    }
}