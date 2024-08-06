<?php

$serverlUrl = 'http://localhost:8200/RESTFUL_API/Day3/JWT_server.php';

$data = ['action'=>'login'];

$options = [
      'http'=>[
          'header'=>'Content-Type:application/x-www-form-urlencoded',
          'method'=>'POST',
          'content'=> http_build_query($data)
      ]
];

$context = stream_context_create($options);
$response = file_get_contents($serverlUrl,false,$context);

if($response === FALSE){ die('Error occured while requesting JWT');}

$responseData = json_decode($response,true);
$jwt = $responseData['token'];

echo "Received JWT= $jwt";

// --- Verify the JWT

$verifyUrl = $serverlUrl.'?jwt='.urlencode($jwt);
$verificatationResponse = file_get_contents($verifyUrl);

if($verificatationResponse === FALSE){
     die('Erro occured while verifying JWT');
}

$verification_data = json_decode($verificatationResponse, true);

if($verification_data['status']==='success'){
      echo 'JWT is valid , Decoded data: \n';
      echo '<br>';
      print_r($verification_data['data']);
}
else{
     echo "JWT Verification failed = ".$verification_data['message'];
}






?>