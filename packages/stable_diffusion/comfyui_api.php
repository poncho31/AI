<?php

$apiUrl        = "http://127.0.0.1:7860/prompt";
$type_api_json       = "";
$type_api      = $argv[1]??"textToImageFast";
$number_output = $argv[1]??5;                   // ex: 5 images eb sortie

switch ($type_api){
    case "textToImageFast":
        $type_api_json= './config/comfyui/textToImage/textToImageFast_api.json';
        break;
    case "textToImage":
        $type_api_json= './config/comfyui/textToImage/textToImage_api.json';
        break;
    default :
        $type_api_json= ' ';
        break;
}
print_r("API : ".basename($type_api_json) ."\r\n");
$type_api_json = file_get_contents($type_api_json);

// Modifiez le prompt comme souhaité
$prompt = json_decode($type_api_json, true);
$prompt["6"]["inputs"]["text"]       = "Generate an image of a beautiful landscape bathed in the soft glow of dawn. In the foreground, a tranquil lake mirrors the warming hues of the sunrise";
$prompt["3"]["inputs"]["seed"]       = $type_api == "textToImageFast" ? 20 : 60;
$prompt["5"]["inputs"]["batch_size"] = $number_output;

// Effectuez la requête HTTP avec le prompt modifié
$prompt = json_encode(["prompt" => $prompt]);
file_put_contents("test.json", $prompt);
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POSTFIELDS, $prompt);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

// Vérifiez si la requête a réussi
if (curl_errno($ch)) {
    echo 'Erreur lors de la requête HTTP : ' . curl_error($ch);
}
else {
    echo 'Requête HTTP réussie. Réponse : ' . $response;
}

// Fermez la session cURL
curl_close($ch);





// functions
function outputConsole($cmd): string
{
    $proc = popen($cmd, 'r');
    $data = '';
    while (!feof($proc)) {
        try{
            $echo = fread($proc, 4096);
            echo "YEEEEEP";
            echo $echo ; // ."\r\n";
            echo "EEEEENNNNND";

            // var_dump(pclose($proc));
            $data .=$echo ."\r\n";
            file_put_contents("./stream_ai.txt", $data);
            // fwrite($proc, "TEST");
        }
        catch(Exception $e){
            var_dump("ERRROOOOR");
            var_dump($e->getMessage());
            var_dump("ERRROOOOR");
        }
    }
    pclose($proc);

    return $data;
}
