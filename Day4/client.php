<?php
 function testRateLimiting($url, $numRequests){
   
    for( $i = 1; $i<=$numRequests; $i++){
         $start = microtime(true); # Record start time
         $response = file_get_contents($url);
         $end = microtime(true); # Record end time
         $duration =  $end - $start;
         
         echo "Request $i: ";
         echo '<pre>';
         print_r($response);
         echo "Request duration: ".round($duration , 4). " seconds \n\n";
         usleep(1000000); # sleep for 1 second between requests
    }

 }


 echo 'Testing Rate Limiting: \n';
 testRateLimiting('http://localhost:8200/RESTFUL_API/Day4/rate_limit_api.php',10)

?>