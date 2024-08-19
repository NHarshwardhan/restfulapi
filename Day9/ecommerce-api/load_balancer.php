<!-- Simple load balancer script -->

<?php
 $endpoints = [
      'catalog' => "http://localhost:8001",
      'order'=> "http://localhost:8002"
 ];

  # Handle the incoming request

  $requestMethod = $_SERVER['REQUEST_METHOD'];

  $requestUri = $_SERVER['REQUEST_URI'];
//   $parsedUrl = parse_url($fullUrl);
//   $path = $parsedUrl['path'];

//   $pathComponents = explode('/',$path);
//   $apiIndex = array_search('api',$pathComponents);
//   $path = implode('/',array_slice($pathComponents, $apiIndex));

  if(strpos($requestUri,'/products') !== false && $requestMethod === 'GET'){
            $url  = $endpoints['catalog'];
  }
  elseif(strpos($requestUri,'/order') !== false && $requestMethod === 'POST'){
            $url  = $endpoints['order'];
  }
  else{
      http_response_code(404);
      echo json_encode(['error'=>"Not Found"]);
      exit;
  } 


  # Forward the request to the appropriate server
  $options = [
    'http'=>[
          'method'=>$requestMethod,
          'header'=>'Content-Type:application/json',
          'content'=>file_get_contents('php://input')
    ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url,false,$context);

    echo $response;




?>