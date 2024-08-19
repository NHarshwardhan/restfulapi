<?php

function getQueueFilePath(){
     $config = require './config/queue.php';
     return $config['queueFilePath'];

}

function initializeQueueFile(){
     $filePath =  getQueueFilePath();
 
     if(!file_exists($filePath)){
       
        #create an empty json file
        file_put_contents($filePath,json_encode([]));
     }
      
}

function normalizePath($path){

      return str_replace(['\\', '/'],DIRECTORY_SEPARATOR, $path);
}

function pushToQueue($data){

     initializeQueueFile();

     $filePath =  getQueueFilePath();

    
     $queue = json_decode(file_get_contents($filePath),true);


     if($queue === null){
         $queue = [];
     }
    
     $data['filePath'] = normalizePath($data['filePath']);
   

     # Add job to queue
     $queue[] = $data;

     if(file_put_contents($filePath, json_encode($queue))===false){
         error_log("Failed to write to queue file");
     };

}



function popFromQueue(){
    initializeQueueFile();
    $filePath =  getQueueFilePath();
    $queue = json_decode(file_get_contents($filePath),true);

    if($queue === null){
       return null; # Handle JSON decoding error 
    }
    if(empty($queue)){
         return null;
    }
   
    $data = array_shift($queue);

    if(file_put_contents($filePath, json_encode($queue))===false){
         error_log('Failed to write updated queue to file');
    }

    return $data;

}

?>