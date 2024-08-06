<?php
 
  $method =  $_SERVER['REQUEST_METHOD'];

  if($method === 'PUT'){
        $input = json_decode(file_get_contents('php://input'),true);
      
        $userid = $_GET['id'] ?? null; 

        if($userid && $input){
             //Assume updating user data in a database
             $updatedUser = ['id'=>$userid, 'name'=>$input['name'], 'email'=>$input['email']];
             header('Content-type: application/json');
             echo json_encode($updatedUser);
        }else{
             http_response_code(400);
             echo json_encode(['error'=>'Bad Request']);
        }
  }else{
       http_response_code(405);
       echo json_encode(['error' => 'Method not allowed']);
  }

?>