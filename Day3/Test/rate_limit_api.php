<?php
// // Define the file to store rate limit data
// $dataFile = 'rate_limit_data.json';

// // Rate limit settings
// $maxRequests = 5;       // Maximum requests allowed
// $timeWindow = 60;       // Time window in seconds

// // Get the client's IP address
// $clientIp = $_SERVER['REMOTE_ADDR'];

// // Load existing rate limit data
// $data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// // Initialize or update the client's rate limit data
// if (!isset($data[$clientIp])) {
//     $data[$clientIp] = [
//         'requests' => 0,
//         'start_time' => time()
//     ];
// }

// $current_time = time();
// $timeElapsed = $current_time - $data[$clientIp]['start_time'];

// // Reset count if the time window has passed
// if ($timeElapsed > $timeWindow) {
//     $data[$clientIp] = [
//         'requests' => 1,
//         'start_time' => $current_time
//     ];
// } elseif ($data[$clientIp]['requests'] < $maxRequests) {
//     $data[$clientIp]['requests']++;
// } else {
//     // Return 429 status if the rate limit is exceeded
//     http_response_code(429); // Too Many Requests
//     echo json_encode([
//         "error" => "Rate limit exceeded. Please try again later.",
//         "timestamp" => date('Y-m-d H:i:s')
//     ]);
//     exit;
// }

// // Save the updated data back to the file
// file_put_contents($dataFile, json_encode($data));

// // API logic: Return some data
// $response = [
//     "message" => "Your requested resource data",
//     "timestamp" => date('Y-m-d H:i:s'),
//     "request_count" => $data[$clientIp]['requests']
// ];

// header('Content-Type: application/json');
// echo json_encode($response);




// ---------------------------throttle---------------------


// Define the file to store rate limit data
$dataFile = 'rate_limit_data.json';

// Rate limit settings
$maxRequests = 6;       // Maximum requests allowed
$timeWindow = 60;       // Time window in seconds
$throttleDelay = 5000;  // Throttle delay in milliseconds if limit is exceeded

// Get the client's IP address
$clientIp = $_SERVER['REMOTE_ADDR'];

// Load existing rate limit data
$data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// Initialize or update the client's rate limit data
if (!isset($data[$clientIp])) {
    $data[$clientIp] = [
        'requests' => 0,
        'start_time' => time()
    ];
}

$current_time = time();
$timeElapsed = $current_time - $data[$clientIp]['start_time'];

// Reset count if the time window has passed
if ($timeElapsed > $timeWindow) {
    $data[$clientIp] = [
        'requests' => 1,
        'start_time' => $current_time
    ];
} elseif ($data[$clientIp]['requests'] < $maxRequests) {
    $data[$clientIp]['requests']++;
} else {
    // Introduce delay if the request count exceeds the threshold
    usleep($throttleDelay * 1000); // Throttle delay in microseconds

    // Return 429 status if the rate limit is exceeded
    http_response_code(429); // Too Many Requests
    echo json_encode([
        "error" => "Rate limit exceeded. Please try again later.",
        "timestamp" => date('Y-m-d H:i:s')
    ]);
    exit;
}

// Save the updated data back to the file
file_put_contents($dataFile, json_encode($data));

// API logic: Return some data
$response = [
    "message" => "Your requested resource data",
    "timestamp" => date('Y-m-d H:i:s'),
    "request_count" => $data[$clientIp]['requests']
];

header('Content-Type: application/json');
echo json_encode($response);
?>


<!-- 
Rate Limit Enforcement:

For requests 1 through 5, the rate limit is within the allowed range, and responses are returned promptly.
For requests 6 through 10, the server returns a 429 Too Many Requests status, indicating that the rate limit was exceeded.
Throttling Delay:

The delay for requests beyond the limit is significant (~2 seconds), which suggests that the usleep function is effectively introducing the throttle delay.
Warnings:

The warnings about failing to open the stream are expected for requests that hit the rate limit. This is because the API returns a 429 response and file_get_contents in the client script fails when receiving this status.
Verification of Throttling
To ensure everything is functioning as intended, let's review the key points:

Rate Limit Exceeded:

After 5 requests, the server starts responding with a 429 status, indicating that the rate limit has been exceeded.
Throttle Delay:

The duration of 2.0 seconds for requests 6 to 10 is consistent with the delay you set in usleep($throttleDelay * 1000);. This means the throttling is effectively delaying responses.
Client Handling:

The client script correctly handles the 429 status by showing the delay and warning messages. -->