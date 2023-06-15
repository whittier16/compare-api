<?php
namespace App\Common\Lib\Application\Libraries\Filterus;

use  App\Common\Lib\Application\Libraries\Filterus\Filters\Arrays,
App\Common\Lib\Application\Libraries\Filterus\Filters\Map,
App\Common\Lib\Application\Libraries\Filterus\Filters\Pool,
App\Common\Lib\Application\Libraries\Filterus\Filters\Chain;


abstract class Filter {

    protected static $filters = array(
        'alnum'  => 'App\Common\Lib\Application\Libraries\Filterus\Filters\Alnum',
        'array'  => 'App\Common\Lib\Application\Libraries\Filterus\Filters\Arrays',
        'bool'   => 'App\Common\Lib\Application\Libraries\Filterus\Filters\Boolean',
        'email'  => 'App\Common\Lib\Application\Libraries\Filterus\Filters\Email',
        'float'  => 'App\Common\Lib\Application\Libraries\Filterus\Filters\Float',
        'int'    => 'App\Common\Lib\Application\Libraries\Filterus\Filters\Int',
        'ip'     => 'App\Common\Lib\Application\Libraries\Filterus\Filters\IP',
        'object' => 'App\Common\Lib\Application\Libraries\Filterus\Filters\Object',
        'raw'    => 'App\Common\Lib\Application\Libraries\Filterus\Filters\Raw',
        'regex'  => 'App\Common\Lib\Application\Libraries\Filterus\Filters\Regex',
        'string' => 'App\Common\Lib\Application\Libraries\Filterus\Filters\String',
        'url'    => 'App\Common\Lib\Application\Libraries\Filterus\Filters\URL'
    );

    public static function arrays($filter = '', $keys = '', $values = '') {
        list(, $options) = static::parseFilter('array,' . $filter);
        if ($keys) {
            $options['keys'] = $keys;
        }
        if ($values) {
            $options['values'] = $values;
        }

        return new Arrays($options);
    }

    public static function map($filters) {
        return new Map(array('filters' => $filters));
    }

    public static function chain() {
        $filters = func_get_args();
        return new Chain(array('filters' => $filters));
    }

    public static function pool() {
        $filters = func_get_args();
        return new Pool(array('filters' => $filters));
    }

    public static function factory($filter) {
        if ($filter instanceof self) {
            return $filter;
        } 
        list ($filterName, $options) = static::parseFilter($filter);
        if (!isset(self::$filters[$filterName])) {
            throw new \InvalidArgumentException('Invalid Filter Specified: ' . $filter);
        }
        $class = self::$filters[$filterName];
        return new $class($options);
    }
    
    public static function registerFilter($name, $class) {
        if (!is_subclass_of($class, __CLASS__)) {
            throw new \InvalidArgumentException("Class name must be an instance of Filter");
        }
        self::$filters[strtolower($name)] = $class;
    }
    

    protected $defaultOptions = array();

    protected $options = array();

    abstract public function filter($var);

    final public function __construct(array $options = array()) {
        $this->setOptions($options);
    }

    public function getOptions() {
        return $this->options;
    }

    public function setOption($key, $value) {
        $this->options[$key] = $value;
        return $this;
    }

    public function setOptions(array $options) {
        $this->options = $options + $this->defaultOptions;
        return $this;
    }

    public function validate($var) {
        $filtered = $this->filter($var);
        return !is_null($filtered) && $filtered == $var;
    }

    protected static function parseFilter($filter) {
        $parts = explode(',', $filter);
        $filterName = strtolower(array_shift($parts));
        $options = array();
        foreach ($parts as $part) {
            $part = trim($part);
            if (empty($part)) {
                continue;
            }
            $filters = explode(':', $part, 2);
            if (is_array($filters)) {
            	if (count($filters) > 1) {
            		list ($name, $value) = $filters;
            		$options[$name] = $value;
            	}
            }
        }
        return array($filterName, $options);
    }
}