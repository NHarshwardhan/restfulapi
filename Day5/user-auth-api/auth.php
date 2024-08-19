<?php

  require_once 'jwt.php';
  require_once 'users.php';
  

function register($conn, $data){
    $email = filter_var($data['email'],FILTER_SANITIZE_EMAIL);
    $password = password_hash($data['password'],PASSWORD_BCRYPT);
    
     if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
         http_response_code(400);
         echo json_encode(['error'=>'invalid email format']);
         exit();
     }

    if(getUserByEmail($conn,$email)){
          http_response_code((409));
          echo json_encode(['error'=>'Email Already Exist']);
          exit();
    }

    $stmt = $conn->prepare("INSERT INTO users(email,password)VALUES(:email,:password)");

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    if($stmt->execute()){
         http_response_code(201);
         echo json_encode(['message'=>'user registered successfully']);
    }else{
        http_response_code(500);
        echo json_encode(['error'=>'Failed to register user']);
    }

}

function login($conn,$data,$secret_key){
    $email = filter_var($data['email'],FILTER_SANITIZE_EMAIL);
    $password =$data['password'];

    $user =  getUserByEmail($conn,$email);

   if($user && password_verify($password,$user['password'])){
      $token = generateJWT($user['id'], $secret_key);
      echo json_encode(['token'=>$token]);
      
   }else{
       http_response_code(401);
       echo json_encode(['error'=>'Invalid credentials']);
   }
      
} 




?>