<?php
 
//  require_once 'db.php';

$host = "localhost";
$db_name = 'library';
$username = 'root';
$password = '';


try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);

   } catch (PDOException $e) {
}


function getUserProfile($userid, $conn){    

    $stmt = $conn->prepare('SELECT * FROM users WHERE id= :id');
    $stmt->execute(['id'=>(int)$userid]);
   
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function generateETag($userdata){
     
    return md5(json_encode($userdata).$userdata['creates_at']);

}

$userid = isset($_GET['id'])?(int)$_GET['id']:1;

$userData = getUserProfile($userid,$conn);


if($userData){
      $etag = generateETag($userData);
   
  
      # Check if ETag matches
      if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] === $etag){
          header('HTTP/1.1 304 Not Modified');
          exit;
      }

      header('Content-Type: application/json');
      header('Cache-Control: max-age=900'); //cache for 15 minutes
      header("ETag:  $etag");    

      echo json_encode($userData);

}else{
     http_response_code(404);
     echo json_encode(['error'=>"User not found"]);
}


?>