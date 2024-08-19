<?php
require_once '../vendor/autoload.php';

session_start();

$client  = new Google\Client();
$client->setClientId('129073015494-251qaa2lcf4u6h1onoj76t5ckq5pgpvq.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost:8200/RESTFUL_API/Day4/outh2callback.php');
$client->addScope('email');
$client->addScope('profile');

if(isset($_GET['code'])){
     $client->fetchAccessTokenWithAuthCode($_GET['code']);
     $_SESSION['access_token'] = $client->getAccessToken();
     $client->setAccessToken($_SESSION['access_token']);
     
     header('Location:api.php');


}
else{
      echo 'Authorization code not found';
}

?>
