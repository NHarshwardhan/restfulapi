<?php
  
   require 'connect.php';

   $data = json_decode(file_get_contents('php://input'),true);
   $taskId = intval($_GET['id']);

   $title = htmlspecialchars($data['title']);
   $description = htmlspecialchars($data['description']);


   $sql = "UPDATE tasks SET title=:title , description=:description WHERE id = :id";
   $stmt = $conn->prepare($sql);
   $stmt->execute(['title'=>$title , 'description'=>$description,'id'=>$taskId]);

   echo json_encode(['message'=>'Task Updated']);




?>