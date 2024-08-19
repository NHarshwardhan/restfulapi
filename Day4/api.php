<?php
 require_once '../vendor/autoload.php';

 session_start();

 $client  = new Google\Client();
 $client->setClientId('129073015494-251qaa2lcf4u6h1onoj76t5ckq5pgpvq.apps.googleusercontent.com');
 $client->setClientSecret('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');
 $client->setRedirectUri('http://localhost:8200/RESTFUL_API/Day4/outh2callback.php');
 $client->addScope('email');
 $client->addScope('profile');

  
 if(!isset($_SESSION['access_token'])){

      header('Location: index.php');
      exit();
 }

 $client->setAccessToken($_SESSION['access_token']);

 if($client->isAccessTokenExpired()){
      header('Location: index.php');
      exit();
 }

$oauth2 = new Google\Service\Oauth2($client);
$userInfo = $oauth2->userinfo->get();

header('Content-type:application/json');
echo json_encode([
      'id'=>$userInfo->id,
      'name'=>$userInfo->name,
      'email'=>$userInfo->email   
]);

?>