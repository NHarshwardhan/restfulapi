<?php

  //Database connection settings
  $host = 'localhost';
  $db = 'library';
  $user = 'root';
  $pass = '';
  $port = 3306;

  try{
        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$db",$user,$pass);
        
  }
  catch(PDOException $e){
          die('Database conenction failed: '. $e->getMessage());
  }

?>


