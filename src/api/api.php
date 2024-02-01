<?php

namespace GillesPinchart\Ai\api;

class api
{
    public function container_init(string $container_name, string $image_name, string $command, string $container_compose_path, string $type_container ="docker"): void
    {
        exec("$type_container start $container_name", $output, $is_error);

        $cmd = <<<CMD
                cd $container_compose_path
                $type_container run $container_name
                $type_container-compose up -d
                $type_container start $container_name
                $type_container exec -it $container_name $image_name $command
        CMD;

        if($is_error){
            $path = __DIR__."\mistral_docker_init.bat";
            file_put_contents($path, $cmd);
            exec("start ".$path);
        }

    }

    public function printMessage($message, $type = 'text', $eol = true): void
    {
        switch ($type) {
            case 'title':
                $color = 42;
                $indent = '';
                break;
            case 'text':
            default:
                $color = 40;
                $indent = $eol ? '               ' : '';
                break;
        }

        $eol = $eol ? "\r\n" : "";
        echo "$indent[1;{$color}m$message[0m$eol"; // ANSI escape codes for color and text formatting
    }

    public function curl_streaming($url, $data): void
    {
        // Init
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Fonction de rappel pour afficher en streaming
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $data) {
            $words = (json_decode($data))->response;

            $this->printMessage($words, "text", false);
            return strlen($data);
        });

        // Exécute la requête
        $response = curl_exec($ch);

        // Vérifie s'il y a des erreurs
        if (curl_errno($ch)) {
            echo 'Erreur cURL : ' . curl_error($ch);
        }
        echo $response;
        // Ferme la session cURL
        curl_close($ch);
    }
}