<?php
require '../../vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

# Create and return a logger instance
// echo __DIR__.'/performance.log';
function getLogger(){
  

    $log = new Logger('Performance_metrics');
    $log->pushHandler(new StreamHandler(__DIR__.'/performance.log',Logger::INFO));
    return $log;
}

