<?php
session_start();

// Rate limit settings
$maxRequests = 5;       // Maximum requests allowed
$timeWindow = 60;       // Time window in seconds
$throttleDelay = 2000;  // Throttle delay in milliseconds after exceeding max requests

// Get the client's IP address
$clientIp = $_SERVER['REMOTE_ADDR'];

// Initialize or update the client's rate limit data
if (!isset($_SESSION['rate_limit'][$clientIp])) {
    $_SESSION['rate_limit'][$clientIp] = [
        'requests' => 0,
        'start_time' => time()
    ];
}

$current_time = time();
$timeElapsed = $current_time - $_SESSION['rate_limit'][$clientIp]['start_time'];

// Log for debugging
error_log("Session Data: " . print_r($_SESSION['rate_limit'][$clientIp], true));

// Reset count if the time window has passed
if ($timeElapsed > $timeWindow) {
    $_SESSION['rate_limit'][$clientIp] = [
        'requests' => 1,
        'start_time' => $current_time
    ];
} else {
    $_SESSION['rate_limit'][$clientIp]['requests']++;
}

// Log current request count and time
error_log("IP: $clientIp, Requests: " . $_SESSION['rate_limit'][$clientIp]['requests'] . ", Time Elapsed: $timeElapsed");

if ($_SESSION['rate_limit'][$clientIp]['requests'] > $maxRequests) {
    // Introduce delay if the request count exceeds the threshold
    error_log("Throttling active for IP $clientIp. Delaying request by $throttleDelay ms.");
    usleep($throttleDelay * 1000); // Throttle delay in microseconds
}

// API logic: Return some data
$response = [
    "message" => "Your requested resource data",
    "timestamp" => date('Y-m-d H:i:s'),
    "request_count" => $_SESSION['rate_limit'][$clientIp]['requests']
];

header('Content-Type: application/json');
echo json_encode($response);
?>
