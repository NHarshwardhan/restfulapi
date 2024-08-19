<?php

// function testRateLimiting($url, $numRequests) {
//     for ($i = 1; $i <= $numRequests; $i++) {
//         $start = microtime(true); // Record start time
//         $response = file_get_contents($url);
//         $end = microtime(true);   // Record end time
//         $duration = $end - $start;

//         echo "Request $i: $response\n";
//         echo "Request duration: " . round($duration, 4) . " seconds\n\n";
//         usleep(1000000); // Sleep for 1 second between requests
//     }
// }

// echo "Testing Rate Limiting API:\n";
// testRateLimiting("http://localhost:8200/RESTFUL_API/Day3/Test/rate_limit_api.php", 10);


// ------------


// for ($i = 1; $i <= 10; $i++) {
//     $response = file_get_contents("http://localhost:8200/RESTFUL_API/Day3/Test/throttle_api.php");
//     echo "Request $i:\n$response\n";
//     sleep(1); // Delay between requests to simulate burst traffic
// }
// echo "Testing Rate Limiting API:\n";

for ($i = 1; $i <= 10; $i++) {
    $startTime = microtime(true);
    $response = file_get_contents("http://localhost:8200/RESTFUL_API/Day3/Test/rate_limit_api.php");
    $endTime = microtime(true);
    
    $requestDuration = $endTime - $startTime;
    echo "Request $i:\n$response\nRequest duration: " . number_format($requestDuration, 4) . " seconds\n";
    sleep(1); // Delay between requests
}
?>


