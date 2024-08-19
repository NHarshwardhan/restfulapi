<?php
 require_once './queue.php';


 if($_SERVER['REQUEST_METHOD']==='POST' && isset($_FILES['file'])){

        $file = $_FILES['file'];

        if($file['error'] === UPLOAD_ERR_OK){

            $uploadDir = __DIR__.'/uploads/';
            $uploadFile = $uploadDir.basename($file['name']);

            // echo $uploadFile;
            if(!file_exists($uploadDir)){
                mkdir($uploadDir,0755,true);
            }

            if(move_uploaded_file($file['tmp_name'],$uploadFile)){
                #push the file processing job to queue
                pushToQueue(['filePath'=>$uploadFile]);
                echo 'File uploaded and processing started....!';
            }else{
                http_response_code(500);
                echo 'Faild to move uploaded file';
            }

             
        }else{
             http_response_code(400);
             echo 'Inavlid file upload';
        } 

 }else{
       http_response_code(404);
       echo 'Not Found';
 }




?>