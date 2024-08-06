<?php

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, 'http://localhost:8200/RESTFUL_API/Day2/Data.php?id=1');
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");


 curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode([
    'name'=>'Peter ',
    'email'=>'peter@gmail.com'
]));

 curl_setopt($ch,CURLOPT_HTTPHEADER,[
    'Content-Type'=>'application/json',
]);


 
 $response = curl_exec($ch);
 curl_close($ch);

 $data = json_decode($response,true);
 print_r($data);



?>