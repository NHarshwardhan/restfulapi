<?php


//  $curl = curl_init();

//  curl_setopt($curl, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts/1');

//  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//  $response = curl_exec($curl);

//  $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

//  curl_close($curl);

//  echo "HTTP Status Code: ".$http_status. PHP_EOL;

//  echo "Response body :" , $response . PHP_EOL;



// ----------------------------------------------------------
    // $curl = curl_init();

    // curl_setopt($curl, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts');

    // $data = json_encode(['title'=>'data1','body'=>'data1_1', 'userId'=>1]);

    // curl_setopt($curl, CURLOPT_POST, true);

    // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    // curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json','Content-Length: '.strlen($data)]);


    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


    // $response = curl_exec($curl);

    // $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    // curl_close($curl);

    // echo "HTTP Status Code: ".$http_status. PHP_EOL;

    // echo "Response body :" , $response . PHP_EOL;



    // -----------------------------------------------------Status Code-----------------------

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, 'http://localhost:8200/RESTFUL_API/day1/books1.php');

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    
    $response = curl_exec($curl);

    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);
   
    if($http_status == 200){
          echo 'Request was successful'.PHP_EOL;
          echo '<pre>';
          echo 'Response Body'.$response.PHP_EOL;
     }else if($http_status == 404){
            echo 'Resource not found(404)'.PHP_EOL;
     }else{
          echo "Request failed with status code".$http_status.PHP_EOL;
     }



?>

<!-- 
     POST /posts HTTP/1.1
     Content-type:application/json
     Body -  JSON Data
  
-->