<?php
require '../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function generateJWT($user_id, $secret_key){
     $payload = [
           'iss'=>'localhost',
           'iat'=>time(),
           'exp'=>time()+3600,
           'sub'=>$user_id
     ];

     return JWT::encode($payload,$secret_key,'HS256');

}

function validateJWT($token,$secret_key){
    try{
          return JWT::decode($token, new Key($secret_key, 'HS256'));
    }
    catch(Exception $e){
         return null;
    }
}


?>