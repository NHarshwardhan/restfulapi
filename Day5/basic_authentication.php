<?php

 define('VALID_USERNAME','admin');
 define('VALID_PASSWORD', 'password123');

 function authenticate(){
      # check if the Authorization header is set
      if(!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])){
          header('WWW-Authenticate: Basic realm="My API"');
          header('HTTP/1.0 401 Unauthorized');
          echo 'Unauthorized';
          exit;
      }

      $username = $_SERVER['PHP_AUTH_USER'];
      $password = $_SERVER['PHP_AUTH_PW'];

      if($username !== VALID_USERNAME || $password !== VALID_PASSWORD){
        header('WWW-Authenticate: Basic realm="My API"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Invalid credentials, Please try again';
        exit;
      }

 }


 authenticate();

 # server the API endpoint
 header('content-type: application/json');

 //Example User Data

 $data = [
    'user'=>'admin',
    'email'=>'admin@example.com'
 ];

 echo json_encode($data);

?>