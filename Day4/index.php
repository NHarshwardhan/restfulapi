<?php
 require_once '../vendor/autoload.php';

 session_start();

 $client  = new Google\Client();
 $client->setClientId('129073015494-251qaa2lcf4u6h1onoj76t5ckq5pgpvq.apps.googleusercontent.com');
 $client->setClientSecret('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');
 $client->setRedirectUri('http://localhost:8200/RESTFUL_API/Day4/outh2callback.php');
 $client->addScope('email');
 $client->addScope('profile');

$authUrl = $client->createAuthUrl();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
       <h1>Login with Google</h1>
       <a href="<?php echo htmlspecialchars($authUrl);?>">Login with Google</a>
</body>
</html>