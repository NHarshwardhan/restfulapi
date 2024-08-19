<?php

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);

$uri = explode('/',trim($uri,'/')); 




if($method === 'POST' && $uri[5]==='create'){
    require 'create_task.php';
}
elseif($method === 'GET' && $uri[4]==='tasks'){
     require 'get_tasks.php'; 
}
elseif($method === 'GET' && $uri[4]==='task' && is_numeric($uri[5])){
      
    $_GET['id'] = $uri[5];
    require 'get_task.php';
}
elseif($method === 'PUT' && $uri[4]==='task' && is_numeric($uri[5]) && $uri[6]==='update'){
      
    $_GET['id'] = $uri[5];
    require 'update_task.php';
}
elseif($method === 'DELETE' && $uri[4]==='task' && is_numeric($uri[5]) && $uri[6]==='delete'){
      
    $_GET['id'] = $uri[5];
    require 'delete_task.php';
}
else{
     http_response_code(404);
     echo json_encode(['message'=>'Not Found']);
}

?>