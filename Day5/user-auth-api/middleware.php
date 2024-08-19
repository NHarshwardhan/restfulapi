<?php
   
   require_once 'jwt.php';

   function authenticate($secret_key){

    $headers = getallheaders();

    if(isset($headers['Authorization'])){
        $header = $headers['Authorization'];
         $h = explode(' ',$header);
         $decoded = validateJWT($h[1],$secret_key);
         if($decoded){
            echo json_encode(['data'=>$decoded]);
            exit();
        }
    }
    http_response_code(401);
    echo json_encode(['error'=>'unauthorized']);
    exit();

   }


?>