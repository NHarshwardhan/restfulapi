<?php

// ----------Work with Form Data---------------------
//  if($_SERVER['REQUEST_METHOD']=== 'POST'){
//       $username = $_POST['username']??'';
//       $email = $_POST['email']?? '';

//       //Example Response
//       echo json_encode([
//          'status'=>'success',
//          'username'=>$username,
//          'email'=>$email
//       ]);
//  }

// ---------------Work with XML---------------------------

        // if($_SERVER['REQUEST_METHOD']==='POST'){
        //       $rawdata = file_get_contents('php://input');

        //       /*
        //             php://input: - read only stream that allow you to access the raw data from the 
        //                            request body in php.

        //                            It is specifically useful when dealing with data sent in a POST request,
        //                            or in format like JSON, XML rather than standard application/x-www-form-urlencoded
        //                            or multipart/form-data(automatically parsed and avialable in $_POST)


        //       */

        //       //parse the XML data
        //       $xml = simplexml_load_string($rawdata);
            
        //       if($xml !== false){
        //              $username = (string)$xml->username;
        //              $email = (string)$xml->email;
                    
        //              echo json_encode([
        //                    'status'=>'success',
        //                    'username'=>$username,
        //                    'email'=>$email
        //              ]);

        //       }else{
        //           http_response_code(400);
        //           echo json_encode(['error'=>'invalid XML']);
        //       }

        // }



// ---------------Work with Validation--------------------
if($_SERVER['REQUEST_METHOD']==='POST'){
     $rawdata = file_get_contents('php://input');
     $data = json_decode($rawdata, true);

     //validate
     $username = filter_var($data['username']??'',FILTER_SANITIZE_STRING);
     $email = filter_var($data['email']??'',FILTER_SANITIZE_EMAIL);
      
     if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            http_response_code(400);
            echo json_encode(['error'=>'Invalid email format']);
            exit;
     }

     echo json_encode([
           'status'=>'success',
           'username'=>$username,
           'email'=> $email
     ]);
     
}else{
      http_response_code(400);
      echo json_encode(['error'=>'Invalid JSON']);
}



?>