<?php
# - Reads from the log file and simulate inventory updates

$logFile = 'order_log.txt';

while(true){
     if(file_exists($logFile) && is_readable($logFile)){

        $logEntries = file($logFile, FILE_IGNORE_NEW_LINES);

        foreach($logEntries as $logEntry){
        
                  if(strpos($logEntry, 'Order placed') !== false){
                      # simulate Update inventory
                      echo "processing inventory update: $logEntry\n";
                  }
        } 
        
    
    
        sleep(5);
     }
     else{
           echo 'Log file not found or not readable. retrying....\n';
     }
}

?>