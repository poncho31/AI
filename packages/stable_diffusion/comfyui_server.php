<?php
$content = file_get_contents('http://localhost:7860/');
var_dump($content);

$output = outputConsole("start docker compose --profile comfy up --build");

var_dump($output);

function outputConsole($cmd)
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