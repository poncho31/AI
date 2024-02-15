<?php

namespace GillesPinchart\Ai\api;

use GillesPinchart\Ai\database\Sqlite;

class api
{
    private int $container_init_count = 0;
    public function container_init(string $container_name, string $image_name, string $command, string $docker_compose_path, string $type_container ="docker"): bool
    {
        // Start container
        $this->printMessage("Création et démarrage du container en cours...");
        $create_and_start_container_cmd = <<<CMD
            cd $docker_compose_path
            docker-compose up -d
            $type_container start $container_name
        CMD;
        exec($create_and_start_container_cmd, $output, $is_error);

        if(!$is_error){
            $container_status = trim(shell_exec("$type_container inspect --format={{.State.Status}} $container_name"));

            // Afficher le statut du conteneur
            $this->printMessage("Statut du conteneur : $container_status");

            // Si le conteneur n'est pas en cours d'exécution, afficher un message d'erreur
            if ($container_status !== "running") {
                $this->printMessage("Erreur : Le conteneur n'est pas en cours d'exécution. Vérifiez le journal pour plus d'informations.");
            }
            else {
                // Exécuter la commande dans le conteneur
                $exec_cmd = "start $type_container exec -it $container_name $image_name $command &";
                exec($exec_cmd, $output);

                // Afficher la sortie de la commande
                $this->printMessage("Sortie de la commande :\n". json_encode($output));
            }

            return true;
        }
        else{
            $this->printMessage("Erreur à la création / démarrage du container");
            return false;
        }


//        if(!$is_error){
//            $cmd = <<<CMD
//                cd $docker_compose_path
//                $type_container-compose up -d
//                $type_container start $container_name
//                $type_container exec -it $container_name $image_name $command
//            CMD;
//            $path = __DIR__."\mistral_docker_init.bat";
//            file_put_contents($path, $cmd);
//            exec("start ".$path);
//            return true;
//        }
//        else{
//            // Création du container
//            exec("$type_container create --name $container_name hello-world", $create_output, $is_error_create);
//            if(!$is_error_create && $this->container_init_count = 0){
//                $this->container_init($container_name,$image_name,$command, $docker_compose_path, $type_container);
//                $this->printMessage("Conteneur créé avec succès.");
//                return true;
//            }
//            else{
//                // Erreur lors de la création du container
//                $this->container_init_count++;
//                $this->printMessage("Erreur lors de la création du container.");
//                return false;
//            }
//        }

    }

    public function create_image_from_container(string $containerName, string $image_name): void
    {
        $image_name = "$image_name:latest";

        // Commande pour obtenir l'ID du conteneur
        $containerIdCommand = "docker ps -aqf \"name=$containerName\"";
        $containerId        = shell_exec($containerIdCommand);

        if ($containerId) {
            // Commande pour sauvegarder le conteneur en tant qu'image
            $commitCommand = "docker commit $containerId";
            $this->printMessage("Commande : $commitCommand");
            $newImageId = trim(shell_exec($commitCommand));

            if ($newImageId) {
                // Renommer l'image avec le nom du repository et le tag
                $tagCommand = "docker tag $newImageId $image_name";
                shell_exec($tagCommand);

                $this->printMessage("Le conteneur $containerName a été transformé en image");
            } else {
                $this->printMessage("Erreur à la création de l'image");
            }
           $this->printMessage("Le conteneur $containerName a été transformé en une image $image_name.");
        }
        else {
            $this->printMessage("Le conteneur $containerName n'existe pas.");
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
            $words = (json_decode($data??''))->response ?? 'No response from curl streaming';

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

    public function create_docker_compose(
            string $docker_compose_path    ,
            string $image_name             ,
            string $image_package          ,
            string $container_name         ,
            string $port                   ,
            string $volume_name            ,
            string $volume_path_docker     ,
            string $volume_path_os         ,
            string $docker_compose_version = '3',
    ): int|bool
    {
        $docker_compose = <<<DOCKER_COMPOSE
            version: '$docker_compose_version'
            services:
              $image_name:
                image: $image_package #ollama_tiny_dolphin_container_image
                container_name: $container_name
                ports:
                  - "$port"
                volumes:
                  - '$volume_name:$volume_path_docker'
            
            volumes:
              $volume_name:
                driver: local
                driver_opts:
                  type: none
                  o: bind
                  device: $volume_path_os

        DOCKER_COMPOSE;

        $docker_compose_file =  file_put_contents("$docker_compose_path\\docker-compose.yaml", $docker_compose);
        return $docker_compose_file;
    }



    public function mistral_docker_compose(string $_DIR__): void
    {
        $this->create_docker_compose(
            "$_DIR__",
            "ollama",
            "ollama/ollama",
            "ollama_mistral_container",
            "11434:11434",
            "ollama_mistral_volume",
            "/usr/share/ollama/mistral/data",
            'K:\projet\AI\src\docker\ollama\volumes\ollama\mistral'
        );

    }



    public function start(string $api_name, ?string $prompt =null, bool $is_streaming = true, ?string $type = "tiny"): void
    {
        // Get ai from DB
        $api = (new Sqlite("ai"))->first("SELECT * FROM ai_api WHERE name = '$api_name'");

        $this->create_docker_compose(
            __DIR__,
            $api['image_name'],
            $api['image_package'],
            $api['container_name'],
            $api['volume_name'],
            $api['volume_path_docker'],
            $api['volume_path_os'],
            $api['docker_compose_version']
        );

        $canRun = $this->container_init(
            $api['container_name'],
            $api['image_name'],
            $api['command'],
            __DIR__,
            $api['container_type']
        );

        $this->create_image_from_container($api['container_name'], "{$api['image_container_name']}");


        if($canRun){
            $data = json_decode($api['api_data_post_field'], true);

            $data['prompt'] = $prompt ?? $data['prompt'];
            $data['stream'] = true;

            $this->printMessage("Votre question : $prompt", "title");

            $this->curl_streaming($api['api_url'], $data);
        }
    }
}