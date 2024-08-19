<?php
# - handles order creation and writes event data to a log file

$logFile = 'order_log.txt';


// Check if the request method is post

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  
    # Reterive and decode the JSON Payload

    $orderData = json_decode(file_get_contents('php://input'),true);

    if(isset($orderData['item']) && isset($orderData['quantity'])){

          # Write the order data to log file

          $logEntry = date('Y-m-d H:i:s'). "- Order placed: Item {$orderData['item']} , Quantity: {$orderData['quantity']})";
          file_put_contents($logFile, $logEntry, FILE_APPEND);

          echo json_encode(['status' => 'Order placed successfully']);


    }else{
        echo json_encode(['status' => 'Invalid order data']);
    }

}else{
    echo json_encode(['status' => 'Only Post requestes are allowed']);
}

?>