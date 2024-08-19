<?php

require_once './fileProcessingService.php';

function processFile($filePath){
     $service =  new FileProcessingService();
     $service->process($filePath);

}


?>