<?php
namespace  App\Common\Lib\Application\Libraries\Filterus\Filters;

use App\Common\Lib\Application\Libraries\Filterus\Filter;

class Float extends Filter {
    
    protected $defaultOptions = array(
        'min' => null,
        'max' => null,
    );

    public function filter($var) {
        if (!is_numeric($var)) {
            return null;
        }
        if (null !== $this->options['min'] && $this->options['min'] > (float)$var) {
            return $this->options['min'];
        } elseif (null !== $this->options['max'] && $this->options['max'] < (float)$var) {
            return $this->options['max'];
        // } elseif ((null !== $this->options['precision']) && ((integer)$this->options['precision'] !== (integer)strlen(substr(strrchr((string)$var, "."), 1))) ) {
        // } elseif (null !== $this->options['precision']) {
        } elseif (!empty($this->options['precision'])) {
            if ((integer)$this->options['precision'] !== (integer)strlen(substr(strrchr((string)$var, "."), 1)))
                return $this->options['precision'];
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