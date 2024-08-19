<!-- Load Testing Script -->

<?php
  $urls = [
       'http://localhost:8200/RESTFUL_API/Day9/ecommerce-api/load_balancer.php/products',
       'http://localhost:8200/RESTFUL_API/Day9/ecommerce-api/load_balancer.php/order'
  ];

  $numRequests = 500;
  $startTime = microtime(true);

  for($i = 0; $i<$numRequests; $i++){
     
    $url = $urls[$i %count($urls)];

    if( $i %2 ==0){
          # GET Request to the catlog
          $start = microtime(true);
          $response = file_get_contents($url);
          $end = microtime(true);
    }
    else{
          # POST request to place an order
          $orderData = json_encode(['product_id'=>rand(1,3),"quantity"=>rand(1,5)]);
          $start = microtime(true);
          $options = [
            'http'=>[
                  'method'=>'POST',
                  'header'=>'Content-Type:application/json',
                  'content'=>$orderData
             ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url,false,$context);
        $end = microtime(true);
    }

    $responseTime =  $end - $start;
    echo "Request $i -  $url: Response Time $responseTime seconds\n";
  }

  $endTime = microtime(true);
  $elapsedTime = $endTime - $startTime;

  echo "Total time for $numRequests requests: $elapsedTime seconds\n";


?>