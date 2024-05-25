<?php
// ESP8266 IP address
$espIP = "192.168.43.231"; // Replace with your ESP8266's IP address

// Check if the request is to turn the LED on or off
$action = $_GET['action'] ?? 'off';

// Create a new cURL resource
$ch = curl_init();

// Set the URL for the request
$url = "http://$espIP/$action";

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Send the request and get the response
$response = curl_exec($ch);

// Check for cURL errors
if ($error = curl_error($ch)) {
    echo "cURL Error: " . $error;
} else {
    echo "LED " . ($action === 'on' ? 'turned on' : 'turned off');
}

// Close the cURL resource
curl_close($ch);