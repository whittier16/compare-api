<?php
namespace App\Modules\Backend\Library;

use \Phalcon\Db\Profiler,
    \Phalcon\Logger,
    \Phalcon\Logger\Adapter\File as FileLogger;

class MyDBListener
{

    protected $_profiler;

    protected $_logger;

    /**
     * Creates the profiler and starts the logging
     */
    public function __construct()
    {
    	$this->_profiler = new Profiler();
        $this->_logger = new FileLogger(__DIR__ . "/../../../Common/logs/backend/debug.log");
    }

    /**
     * This is executed if the event triggered is 'beforeQuery'
     */
    public function beforeQuery($event, $connection)
    {
        $this->_profiler->startProfile($connection->getSQLStatement());
    }

    /**
     * This is executed if the event triggered is 'afterQuery'
     */
    public function afterQuery($event, $connection)
    {
        
    	$this->_logger->log($connection->getSQLStatement(), Logger::INFO);
        $this->_profiler->stopProfile();
    }

    public function getProfiler()
    {
        return $this->_profiler;
    }
}