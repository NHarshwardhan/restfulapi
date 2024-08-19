<?php

# DB Connection

$dsn = 'mysql:host=localhost;dbname=library';
$username = 'root';
$password = '';
$conn = new PDO($dsn,$username,$password);

# Measure request start time
$start_time = microtime(true);

# process the API request example 
header('Content-Type: application/json');
echo json_encode(['message'=>'API request processed']);


# Measure request end time
$end_time = microtime(true);
$response_time = $end_time -  $start_time;

# Log the request
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];
$status_code = http_response_code();


$stmt = $conn->prepare("INSERT INTO api_logs(method, endpoint, status_code, response_time)VALUES(:method, :uri,:status_code,:response_time)");

$stmt->execute([
    ':method'=>$request_method,
    ':uri' =>$request_uri,
    ':status_code'=>$status_code,
    ':response_time'=>$response_time
])


?>