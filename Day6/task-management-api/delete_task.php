<?php

require 'connect.php';

$taskId = intval($_GET['id']);

$sql = "DELETE FROM tasks WHERE id = :id";

$stmt = $conn->prepare($sql);

$stmt->execute(['id'=>$taskId]);

echo json_encode(['message'=>'Task deleted']);

?>