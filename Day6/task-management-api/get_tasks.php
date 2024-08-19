<?php
 require 'connect.php';

 header('Content-type:application/json');

 $sql = 'SELECT * FROM tasks';
 $stmt = $conn->query($sql);
 $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
 $response = [
     'tasks'=>array_map(function($task){
         return [
                'id'=>$task['id'],
                'title'=>$task['title'],
                'description'=>$task['description'],
                'links'=>[
                    'self'=>"/task/{$task['id']}",
                    'update'=>"/task/{$task['id']}/update",
                    'delete'=>"/task/{$task['id']}/delete"
                ]
         ];
     },$tasks)
    ];

echo json_encode($response);

?>