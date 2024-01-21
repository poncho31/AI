<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:11434/api/generate');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); // Set the request method as POST

$headers = array();
$headers[] = 'Content-Type: application/json'; // Add headers
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Set headers

$data = json_encode(array("model" => "mistral", "prompt" => "Give one iconic guitarist")); // Data to send in the request body
curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Add data

// Execute the request and get response
$response = curl_exec($ch);
$jsonResponse = [];
// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    $jsonResponse = explode("
", $response); // Decode the JSON response
    var_dump($jsonResponse); // Print the decoded response as a PHP object or array
}

curl_close($ch); // Close cURL session


echo implode(" ",array_column($jsonResponse, "response"));