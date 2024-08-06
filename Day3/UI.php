<?php
// -----------------GET--------------
$url = 'http://localhost:8200/RESTFUL_API/Day3/books.php';

$ch = curl_init($url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
echo json_encode($data);

//------ POST--------

// $url = 'http://localhost:8200/RESTFUL_API/Day3/books.php';

// $data = json_encode([
//       'title'=>'Book 5',
//       'author'=> "Kerry Parker"
// ]);

// $ch = curl_init($url);
// curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
// curl_setopt($ch,CURLOPT_POST,true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// curl_setopt($ch, CURLOPT_HTTPHEADER,['Content-type:application/json']);
// $response = curl_exec($ch);
// curl_close($ch);

// $data = json_decode($response, true);
// print_r($data);


// -------PUT--------------
    // $url = 'http://localhost:8200/RESTFUL_API/Day3/books.php/1';

    // $data = json_encode([
    //       'title'=>'Ghost Rider',
    //       'author'=> "Ghost Dawson"
    // ]);

    // $ch = curl_init($url);
    // curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    // curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'PUT');
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    // curl_setopt($ch, CURLOPT_HTTPHEADER,['Content-type:application/json']);
    // $response = curl_exec($ch);
    // curl_close($ch);

    // $data = json_decode($response, true);
    // print_r($data);


// --------------Delete--------------------
//   $url = 'http://localhost:8200/RESTFUL_API/Day3/books.php/1';

//     $ch = curl_init($url);
//     curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//     curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'DELETE');
  
//     $response = curl_exec($ch);
//     curl_close($ch);

//     $data = json_decode($response, true);
//     print_r($data);

?>