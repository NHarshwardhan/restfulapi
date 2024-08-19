<!-- Order Processing API -->
<?php
  header('Content-Type: application/json');

  # Simulate order processing
  $order = json_decode(file_get_contents('php://input'),true);


  // simulate delay
  usleep(100000); # 100ms delay

  $response = ["status"=>"success", "order_id"=>rand(1000,9999)];
  echo json_encode($response);


?>