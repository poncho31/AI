<?php
header("Access-Control-Allow-Origin: http://localhost:1113");
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'));

if (isset($data->message)) {
    $responseData = array('message' => 'Your message here.'); // Replace this with the actual Ollama API response.
  echo json_encode($responseData);
} else {
    $responseData = file_get_contents('api-response.json');
    echo $responseData;
}