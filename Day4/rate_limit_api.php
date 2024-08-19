<!-- file-based approach correctly limits requests and return the 429 status when the limit exceeded. -->
 <?php
   # Rate Limiting-------

        //  # Define the file to store rate limit data
        //  $dataFile = 'rate_limit_data.json';

        //  # Rate limit settings
        //  $maxRequests = 5;  # Maximum requests allowed
        //  $timewindow = 60; # Time window in seconds

        //  #Get the client's IP address
        //  $clientIp = $_SERVER['REMOTE_ADDR'];

        //  # Load existing rate limit data
        //  $data = file_exists($dataFile)? json_decode(file_get_contents($dataFile),true):[];

        //  # Initialize or update the client's rate limit data
        //  if(!isset($data[$clientIp])){
        //      $data[$clientIp] = ['requests'=>0 , 'start_time'=>time()];     
        //  }

        //  $current_time = time();
        //  $timeElapsed = $current_time - $data[$clientIp]['start_time'];

        //  # Reset count if the time window has passed.
        //  if($timeElapsed >  $timewindow){
        //     $data[$clientIp] = ['requests'=>1 , 'start_time'=>$current_time];   
        //  }
        //  elseif($data[$clientIp]['requests'] < $maxRequests){
            
        //       $data[$clientIp]['requests']++;
        //  }
        //  else{
        //       # return 429 status if the rate limit is exceeded
        //       http_response_code(429);
        //       echo json_encode([
        //            'error'=>'Rate limit exceeded , please try again',
        //            'timestamp'=>date('Y-m-d H:i:s')
        //       ]);
        //       exit;
        //  }


        //  # save the updated data back to the file
        //   file_put_contents($dataFile, json_encode($data));

        //   # Api logic: Return some data
        //   $response = [
        //        "message"=>"Your requested resource data",
        //        "timestamp"=>date('y->m->d H:i:s'),
        //        "request_count"=>$data[$clientIp]['requests']

        //   ];

        //   header('Content-type:application/json');
        //   echo json_encode($response);


   # Throttle------------
 # Define the file to store rate limit data
 $dataFile = 'rate_limit_data.json';

 # Rate limit settings
 $maxRequests = 5;  # Maximum requests allowed
 $timewindow = 60; # Time window in seconds
 $thorttleDelay = 2000 ; # Throttle delay in milliseconds if limit is exceeded

 #Get the client's IP address
 $clientIp = $_SERVER['REMOTE_ADDR'];

 # Load existing rate limit data
 $data = file_exists($dataFile)? json_decode(file_get_contents($dataFile),true):[];

 # Initialize or update the client's rate limit data
 if(!isset($data[$clientIp])){
     $data[$clientIp] = ['requests'=>0 , 'start_time'=>time()];     
 }

 $current_time = time();
 $timeElapsed = $current_time - $data[$clientIp]['start_time'];

 # Reset count if the time window has passed.
 if($timeElapsed >  $timewindow){
    $data[$clientIp] = ['requests'=>1 , 'start_time'=>$current_time];   
 }
 elseif($data[$clientIp]['requests'] < $maxRequests){
    
      $data[$clientIp]['requests']++;
 }
 else{
      
      //Introduce delay if the request count exceeds the threshold
      usleep($thorttleDelay * 1000); # throttle delay in microseconds

      
      # return 429 status if the rate limit is exceeded
      http_response_code(429);
      echo json_encode([
           'error'=>'Rate limit exceeded , please try again',
           'timestamp'=>date('Y-m-d H:i:s')
      ]);
      exit;
 }


 # save the updated data back to the file
  file_put_contents($dataFile, json_encode($data));

  # Api logic: Return some data
  $response = [
       "message"=>"Your requested resource data",
       "timestamp"=>date('y->m->d H:i:s'),
       "request_count"=>$data[$clientIp]['requests']

  ];

  header('Content-type:application/json');
  echo json_encode($response);

?>
?>