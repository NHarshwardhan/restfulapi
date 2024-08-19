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


function getUserByEmail($email, $conn){    

    # Start Timing
    $startTime = microtime(true);

    $stmt = $conn->prepare('SELECT * FROM users WHERE email= :email');
    $stmt->execute(['email'=>$email]);

    # End Timing
    $endTime = microtime(true);

    # calculate the execution time
    $executionTime = $endTime  - $startTime;

   
   $userdata = $stmt->fetch(PDO::FETCH_ASSOC);

   return ['executionTime'=>$executionTime , 'data'=>$userdata];

}

$email = 'user1@example.com';
$result = getUserByEmail($email,$conn);

header('Content-Type:application/json');
echo json_encode($result);
?>