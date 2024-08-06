<?php
  
  header('Cache-Control: public, max-age=3600');
  header('Content-Type: application/json');

  $user = ['id'=>1, 'name'=>'John Doe', 'email'=>'john@gmail.com'];
  echo json_encode($user);

?>