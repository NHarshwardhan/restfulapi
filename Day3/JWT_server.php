<?php
require '../vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$key = 'wfewrwed2wdw32ed';
$servername = 'localhost';

// Helper function to create a JWT
function createJWT($userid, $role, $key, $servername){
       $issuedAt = time();
       $expirationTime = $issuedAt+3600; // valid for 1 hour

       $payload = [
            'iss'=>$servername,
            'aud'=>$servername,
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'userId'=>$userid,
            'role'=>$role
       ];

       return JWT::encode($payload,$key,'HS256');


}

// Helper function to verify a JWT

function verifyJWT($jwt, $key){
   try{
       $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
       return (array) $decoded; // return the decoed payload as an array

   }
   catch(Exception $e){
     return false;
   }
}

// Handle the request

if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['action']) && $_POST['action']==='login'){
          $userid = 123;
          $role = 'admin';

          //Create JWT Token
          $jwt = createJWT($userid, $role, $key,$servername);

          echo  json_encode(['token'=>$jwt]);
    }
   
}
else if($_SERVER['REQUEST_METHOD']==='GET'){
    if(isset($_GET['jwt'])){
         $jwt = $_GET['jwt'];

         //verify the token
         $decoded = verifyJWT($jwt,$key);

         if($decoded){
              echo json_encode(['status'=>'success','data'=>$decoded]);
         }else{
            echo json_encode(['status'=>'success','message'=>'Invalid or expired token']);
         }
         
    }
}
else{
    echo json_encode(['status'=>'Invalid request method']);
}

?>