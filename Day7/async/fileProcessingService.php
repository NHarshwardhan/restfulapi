<?php

class FileProcessingService{

     public function process($filePath){

         echo "Processing file: $filePath \n";
         sleep(5); # simulate processing time
         echo "File Processed: $filePath\n";
     }
}


?>