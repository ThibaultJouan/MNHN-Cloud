<?php
/**
*WARN: les / peuvent devenir des \\ sur windows
*/
include(__DIR__.'/../../apache-log4php-2.3.0/src/main/php/Logger.php');
class Logger
{
     public function getLog(){
        Logger::configure(__DIR__.'/config/config.xml');

        $log = Logger::getLogger('myLogger');

        return $log;
     }
}