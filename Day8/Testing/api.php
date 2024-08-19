<?php
require '../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\KEY;

header('Content-type:application/json');

$dsn = 'mysql:host=localhost;dbname=testing';
$username = 'root';
$password = '';

$pdo = new PDO($dsn, $username, $password);

#---------------------
 $scriptName = $_SERVER['SCRIPT_NAME'];  //RESTFUL_API\Day8\Testing\api.php
 $basePath = dirName($scriptName);  #RESTFUL_API\Day8\Testing

 $uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
 $uri = str_replace($basePath, '',$uri);


#-------------------------------------------------------
function respond($data,$status=200){
     http_response_code($status);
     echo json_encode($data);
     exit;
}
function getBearerToken(){
    $headers = getallheaders();
    if(isset($headers['Authorization'])){
         if(preg_match('/Bearer\s(\S+)/', $headers['Authorization'],$matches)){
            return $matches[1];
         }
    }
    return null;

}

function verifyJWT($token, $key){
     try{
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return $decoded;
     }
     catch(Exception $e){
         return null;
     }
}

$secretKey = "wreqwewe32ewde";

// ----------------------------------------------------------
#Register
if($_SERVER['REQUEST_METHOD']==='POST' && $uri === '/api/register'){
   
    $input = json_decode(file_get_contents('php://input'),true);
    
    if(!isset($input['username']) || !isset($input['password'])){
         respond(['message'=>'Invalid input'],422);
    }
  
    $username = $input['username'];
    $password = password_hash($input['password'],PASSWORD_BCRYPT);
    
    $stmnt = $pdo->prepare("INSERT INTO users(username,password)VALUES(:username,:password)");
    $stmnt->execute(['username'=>$username, 'password'=>$password]);

    respond(['message'=>'User registered successfully'],201);


}

#Login
if($_SERVER['REQUEST_METHOD']==='POST' && $uri === '/api/login'){
    $input = json_decode(file_get_contents('php://input'),true);
    
    if(!isset($input['username']) || !isset($input['password'])){
         respond(['message'=>'Invalid input'],422);
    }

    $stmnt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmnt->execute(['username'=>$input['username']]);
    $user = $stmnt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($input['password'], $user['password'])){
         $payload = [
            'iss'=> "http://localhost",
            'iat'=> time(),
            'exp' =>time()+3600,
            'sub' => $user['id']
         ];

         $jwt = JWT::encode($payload,$secretKey,'HS256');
        respond(['token'=>$jwt], 200);



    }else{
        respond(['message'=>'Invalid Crendentials'],401);
    }
  
}
#GET TASK
if($_SERVER['REQUEST_METHOD']==='GET' && $uri === '/api/tasks'){
         $token = getBearerToken();
         $decodedToken = verifyJWT($token, $secretKey);

         if(!$decodedToken){
             respond(['message'=>'Unauthorized'],401);
         }

         $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id=:user_id");
         $stmt->execute(['user_id'=>$decodedToken->sub]);
         $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
         respond($tasks);

}
#Create TASK
if($_SERVER['REQUEST_METHOD']==='POST' && $uri === '/api/tasks'){
    $input = json_decode(file_get_contents('php://input'),true);
   
    if(!isset($input['title']) || empty($input['title'])){
        respond(['message'=>'Title is required'],422);
    }

    $token = getBearerToken();
    $decodedToken = verifyJWT($token, $secretKey);

    if(!$decodedToken){
        respond(['message'=>'Unauthorized'],401);
    }

    $stmnt = $pdo->prepare("INSERT INTO tasks(title,description,user_id)VALUES(:title,:description,:user_id)");
    $stmnt->execute(['title'=>$input['title'], 'description'=>$input['description'] ?? null,'user_id'=>$decodedToken->sub,]);

    $task = [
          'id'=> $pdo->lastInsertId(),
          'title'=>$input['title'],
          'description'=>$input['description'] ?? null
    ];

    respond($task,201);


}

# Update TASK
if($_SERVER['REQUEST_METHOD']==='PUT' && preg_match('/\/api\/tasks\/(\d+)/',$uri,$matches)){
    
    $taskId = $matches[1];

    $input = json_decode(file_get_contents('php://input'),true);
     
    $token = getBearerToken();
    $decodedToken = verifyJWT($token, $secretKey);

    if(!$decodedToken){
        respond(['message'=>'Unauthorized'],401);
    }
   
    $stmnt = $pdo->prepare("UPDATE tasks SET title= :title , description= :description WHERE id= :id AND user_id= :user_id");
    $stmnt->execute([
        'title'=>$input['title']??null, 
        'description'=>$input['description'] ?? null, 
        'id'=>$taskId,
        'user_id'=>$decodedToken->sub,
    ]);

    $stmnt = $pdo->prepare("SELECT * FROM tasks WHERE id= :id AND user_id= :user_id");
    $stmnt->execute([  'id'=>$taskId,   'user_id'=>$decodedToken->sub    ]);
    $task = $stmnt->fetch(PDO::FETCH_ASSOC);

    if($task){
        respond($task);
    }else{
        respond(['message'=>' Task not found or unathorized']);
    }

     
        
       

   

    


}


# Delete Task
if($_SERVER['REQUEST_METHOD']==='DELETE' && preg_match('/\/api\/tasks\/(\d+)/',$uri,$matches)){
    
    $taskId = $matches[1];

    $input = json_decode(file_get_contents('php://input'),true);
     
    $token = getBearerToken();
    $decodedToken = verifyJWT($token, $secretKey);

    if(!$decodedToken){
        respond(['message'=>'Unauthorized'],401);
    }
   
    $stmnt = $pdo->prepare("DELETE FROM tasks  WHERE id= :id AND user_id= :user_id");
    $stmnt->execute([  'id'=>$taskId,   'user_id'=>$decodedToken->sub    ]);

    if($stmnt->rowCount()){
        respond(null, 204);
    }else{
        respond(['message'=>' Task not found or unathorized'],404);
    }
}

respond(['message'=>'Route not found'], 404);
?>





