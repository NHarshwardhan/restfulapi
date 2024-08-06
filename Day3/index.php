<?php
header("Access-Control-Allow-Origin: *");

 if(preg_match('/^\/book/',$_SERVER['REQUEST_URI'])){
       include 'books.php';
 }
 else{
      http_response_code(404);
      echo json_encode(['message'=>'Endpoint not found']);
 }


?>