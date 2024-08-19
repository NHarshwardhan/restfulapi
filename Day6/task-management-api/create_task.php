<?php

require 'connect.php';

$data = json_decode(file_get_contents('php://input'),true);

$title = htmlspecialchars($data['title']);
$description = htmlspecialchars($data['description']);


$sql = "INSERT INTO tasks (title , description) VALUES(:title, :description)";
$stmt = $conn->prepare($sql);
$stmt->execute(['title'=>$title, 'description'=>$description]);

echo json_encode(['message'=>'Task Created']);







?>