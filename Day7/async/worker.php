<?php
require './queue.php';
require './fileProcessingJob.php';

while(true){
      
    try{
        $job = popFromQueue();
         if($job){
             processFile($job['filePath']);
         }else{
              sleep(1); #sleep tp avoid busy waiting
         }

    }
    catch(Exception $e){
         echo "Error: ".$e->getMessage();
    }

}


?>