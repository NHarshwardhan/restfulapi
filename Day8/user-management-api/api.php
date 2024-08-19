<?php
 require_once './user_service.php';

 header('Content-Type: application/json');

 $method = $_SERVER['REQUEST_METHOD'];

 $input = json_decode(file_get_contents('php://input'),true);

 $id = $_GET['id'] ?? null;

 switch($method){
      case 'GET':
          if($id){
              $user = getUserService($id);
              echo json_encode($user);
          }
          break;
    case 'POST':
         $name = $input['name']?? null;
          if($name){
              $user = createUserService($name);
              echo json_encode($user);
          }
          break;

    case 'PUT':
         
          if( $id && isset($input['name'])){
              $updatedUser = updateUserService($id,$input['name']);
              echo json_encode($updatedUser);
          }
          break;

      case 'DELETE':
          if($id){
              $user = deleteUserService($id);
              echo json_encode(['deleted'=>$deleted]);
          }
          break;  

 }




?>