<?php
// FICHIER
$aiAutoImproveFile = file_get_contents('./_ai_auto_improve.bat');
var_dump($aiAutoImproveFile);

// INIT API
$AI_model="ollama-mistral";
$output = outputConsole("start ..\AI.bat docker-ai $AI_model AI_CONTAINER 11436");

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