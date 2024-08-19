<?php
require '../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once 'db.php';
require_once 'auth.php';
require_once 'middleware.php';
require_once 'users.php';


$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/',parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH));

$secret_key ='324123123dewdewrrewdewr';
$encryption_key = 'abc12345';

$conn = getConnection();
// echo '<pre>';
// print_r($uri[5]);

switch($method){
      case 'POST':
        if($uri[5]=== 'register'){
             register($conn,json_decode(file_get_contents('php://input'),true));
        }elseif($uri[5]=== 'login'){
              login($conn, json_decode(file_get_contents("php://input"),true), $secret_key);
        }elseif($uri[5]=== 'notes'){
             $headers = getallheaders();
             $authHeader = $headers['Authorization']??'';
             if(preg_match('/Bearer\s(\S+)/',$authHeader,$matches)){
                   $token = $matches[1];
                    
                   try{
                       $decoded = JWT::decode($token,new Key($secret_key, 'HS256'));
                       $userid = $decoded->sub;
                       $content = encryptData($_POST['content'], $encryption_key);

                       $sql = "INSERT INTO notes(user_id,content)VALUES(:user_id,:content)";
                       $stmt= $conn->prepare($sql);
                       $stmt->bindParam(':user_id', $userid);
                       $stmt->bindParam(':content',$content);
                       $stmt->execute();
                       echo json_encode(['message'=>'Note created successfully']);


                              
                   }
                   catch(Exception $e){
                             http_response_code(401);
                             echo json_encode(['message'=>'invalid Json']);
                   }
             }else{
                  http_response_code(401);
                  echo json_encode(['message'=>'invalid Json']); 
             }

        }
        break;
        case 'GET':
            if($uri[5]=== 'profile'){
               $decoded = authenticate($secret_key);
            //    $user = getUserById($conn, $decoded->sub);
            //    echo json_encode($user);
            }elseif($uri[5]==='notes'){
                  $headers = getallheaders();
                  $authHeader = $headers['Authorization']??'';
                  if(preg_match('/Bearer\s(\S+)/',$authHeader,$matches)){
                        $token = $matches[1];
                         
                        try{
                            $decoded = JWT::decode($token,new Key($secret_key, 'HS256'));
                            $userid = $decoded->sub;                           
     
                            $sql = "SELECT content FROM notes WHERE user_id=:user_id";
                            $stmt= $conn->prepare($sql);
                            $stmt->bindParam(':user_id', $userid);
                        
                            $stmt->execute();
                            $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            foreach($notes as &$note){
                                  $note['content'] = decryptData($note['content'],$encryption_key);
                                  
                            }
                       
                            echo json_encode($notes);
     
                                   
                        }
                        catch(Exception $e){
                                  http_response_code(401);
                                  echo json_encode(['message'=>'invalid Json']);
                        }
                  }else{
                       http_response_code(401);
                       echo json_encode(['message'=>'invalid Json']); 
                  }
            }
            break;

        default:
          http_response_code(405);
          echo json_encode(['error' => 'Method not allowed']);
          break;

}

// -------------Encryption--------------------

function encryptData($data, $key){
   $cipher = 'aes-256-cbc';
   $ivlen = openssl_cipher_iv_length($cipher);
   $iv =  openssl_random_pseudo_bytes($ivlen);
   $cipherText = openssl_encrypt($data,$cipher,$key,$option=0,$iv);
   return base64_encode($iv.$cipherText);
}

function decryptData($cipherText, $key){
      $cipher = 'aes-256-cbc';
      $ivlen = openssl_cipher_iv_length($cipher);
      $ciphertext = base64_decode($cipherText);
      
      $iv =  substr($ciphertext,0, $ivlen);
      $ciphertext =  substr($ciphertext, $ivlen);
      return openssl_decrypt($ciphertext, $cipher,$key,$option=0,$iv);
   }


?>