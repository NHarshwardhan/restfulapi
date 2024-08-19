<?php
 require 'connect.php';

 header('content-type: application/json');

 $taskId = intval($_GET['id']);

 $sql = "SELECT * FROM tasks WHERE id = :id";
 $stmt= $conn->prepare($sql);
 $stmt->execute(['id'=>$taskId]);
 $task = $stmt->fetch(PDO::FETCH_ASSOC);

 if(!$task){
      http_response_code(404);
      echo json_encode(['message'=>'Task not found']);
      exit;
 }

 $response = [
      'task'=>[
        'id'=>$task['id'],
        'title'=>$task['title'],
        'description'=>$task['description'],
        'links'=>[
            'self'=>"/tasks/{$task['id']}",
            'update'=>"/tasks/{$task['id']}/update",
            'delete'=>"/tasks/{$task['id']}/delete"
        ]
      ]
];

echo json_encode($response);



?>