<?php
  # - Read from the log file and simulate sending notifications

  
$logFile = 'order_log.txt';
 while(true){
    
$logEntries = file($logFile, FILE_IGNORE_NEW_LINES);

foreach($logEntries as $logEntry){

    if(strpos($logEntry, 'Order placed') !== false){
        # simulate Update inventory
        echo "sending notification: $logEntry\n";
    }
}



sleep(5);

 }

?>