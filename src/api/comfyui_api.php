<?php

$apiUrl        = "http://127.0.0.1:7860/prompt";
$type_api_json = "";
$prompt        = $argv[1]??"Generate an image of a beautiful landscape bathed in the soft glow of dawn. In the foreground, a tranquil lake mirrors the warming hues of the sunrise";
$number_output = $argv[2]??1;                   // ex: 5 images eb sortie
$type_api      = $argv[3]??"textToImageFast";


$configPath    = "../../packages/stable_diffusion/config";
switch ($type_api){
    case "textToImageFast":
        $type_api_json= "$configPath/comfyui/textToImage/textToImageFast_api.json";
        break;
    case "textToImage":
        $type_api_json= "$configPath/comfyui/textToImage/textToImage_api.json";
        break;
    default :
        $type_api_json= ' ';
        break;
}
print_r("API : ".basename($type_api_json) ."\r\n");
echo "$prompt $number_output $type_api \r\n";

// Va chercher la configuration pour Comfy ui
$type_api_json = file_get_contents($type_api_json);

// Modifiez le prompt comme souhaité
$prompt = json_decode($type_api_json, true);
$prompt["6"]["inputs"]["text"]       = $prompt;
$prompt["3"]["inputs"]["seed"]       = $type_api == "textToImageFast" ? 20 : 60;
$prompt["5"]["inputs"]["batch_size"] = $number_output;

// Effectuez la requête HTTP avec le prompt modifié
$prompt = json_encode(["prompt" => $prompt]);
// file_put_contents("test.json", $prompt);
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


function prompt() : array{
    return [
        'human'=>[
            'face' => 'Clear facial features @@name@@'
        ],
        'photo'=>[
            "Travel blogs/websites"                         => "Generate photos of sunsets casting a warm glow on the ancient ruins of [name the landmark]. | Generate a photo illustrating the vibrant and intricate rituals during the festival of [festival name]. | Create a photo showcasing the atmosphere of [name destination].",
            "E-commerce/online retail platforms"            => "Generate a photo showcasing [product] in action. [Expain the scene] | Generate photos of a [product] in various settings, highlighting [product features].",
            "Business websites/corporate blogs"             => "Generate photos of an executive team in a strategic retreat setting, fostering a sense of unity and vision. | Create photos showcasing employees working in a [explain office environment] | Create photos that convey a [specify niche] company’s global reach and influence through impactful projects.",
            "Lifestyle magazines/websites"                  => "Create stunning photos capturing the essence of a high-fashion runway show, featuring the latest couture. | Generate a photo illustrating a [interior design style] home with eclectic decor and cozy corners. | Generate a photo of a signature dish, emphasizing the artistry of culinary creations.",
            "Educational platforms/e-Learning websites"     => "Generate photos of students actively participating in a [specify type of workshop]. | Generate photos of students donning caps and gowns, celebrating academic achievements.",
            "Event management websites/promotion platforms" => "Generate visuals of dynamic keynote speakers captivating the audience at your conference. | Capture the excitement of professionals networking and exchanging ideas at an event in a photograph.",
            "Wellness blogs/healthcare platforms"           => "Create an image visualizing serene yoga poses in natural settings, promoting mental and physical well-being. | Showcase farmers harvesting organic produce for a healthy and sustainable lifestyle. | Generate photos of individuals finding tranquility in a meditation retreat setting.",

        ]
    ];
}