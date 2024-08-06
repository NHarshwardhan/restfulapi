<?php
 //Database connection
 $pdo= new PDO('mysql:host=localhost;dbname=library','root','');

 //Function to generate a new API key and store it in the database
 function generateApiKey($pdo){
      $new_key = bin2hex(random_bytes(16));
      $stmt = $pdo->prepare('INSERT INTO api(apikey)VALUES(:key)');
      $stmt->execute(['key'=>$new_key]);
      return $new_key;
 }

 //function to validate the API key
 function validateApiKey($pdo, $api_key){
      $stmt = $pdo->prepare('SELECT COUNT(*) FROM api WHERE apikey = :key');
      $stmt->execute(['key'=>$api_key]);
      return $stmt->fetchColumn()>0;
 }

 //function to revoke an api key
 function revokeApiKey($pdo,$apiKey){
      $stmt = $pdo->prepare('DELETE FROM api WHERE apikey=:key');
      $stmt->execute(['key'=>$apiKey]);
 }


//  Handle action

$action = $_GET['action'] ?? '';

switch($action){
      case 'generate':
        $new_key = generateApiKey($pdo);
        echo "New Api Key generated: $new_key";
        break;

      case 'revoke':
          $api_key = $_GET['api_key']?? $_SERVER['HTTP_X_API_KEY']?? '';
          if($api_key){
              revokeApiKey($pdo,$api_key);
              echo 'Api Key revoked successfully';
          }else{
              echo "Api Key not provided";
          }
          break;
       
      case 'api':
          $api_key = $_GET['api_key']?? $_SERVER['HTTP_X_API_KEY']?? '';
          if(validateApiKey($pdo,$api_key)){
             $response = [
                'message'=>'Authenticated successfully',
                'data'=>['example'=>'data']
             ];
             header('Content-type: application/json');
             echo json_encode($response);
          }else{
              header('Http/1.1 401 Unauthorized');
              echo json_encode(['error'=>'Invalid API Key']);
          }
          break;
      
       default:
         echo "Invalid action, Use 'generate', 'api";
         break;


        }


?>