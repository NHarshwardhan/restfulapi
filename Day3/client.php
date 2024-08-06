<?php

//Define the base URL of the API SYSTEM
$base_url = 'http://localhost:8200/RESTFUL_API/Day3/api_system.php';

//Function to make  a GET request to the API

function makeApiRequest($url, $headers = []){
    $options = [
          'http'=>[
             'header' => implode("\r\n",$headers),
             'method'=> 'GET'
          ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url,false,$context);

    if($response===FALSE){
         return 'Error Occured';
    }
    return $response;

}

// Handle action
// $action = 'generate';
// $api_key = '';

// $action = 'api';
// $api_key = '1ac88e525a437b539c56d9757d7601e6';

$action = 'revoke';
$api_key = '1ac88e525a437b539c56d9757d7601e6';

//Action-specific URL and headers
$url = "$base_url?action=$action";
$headers = ($action==='api'||'revoke')?["X-API-Key:$api_key"]:[];

//Make the API request
 $response = makeApiRequest($url,$headers);
 echo "Response: $response";



?>