<?php

namespace GillesPinchart\Ai\api;

class api
{
    private int $container_init_count = 0;
    public function container_init(string $container_name, string $image_name, string $command, string $container_compose_path, string $type_container ="docker"): bool
    {
        // Le container est il démarré
        $this->printMessage("Création et démarrage du conteneur en cours...");
        $create_and_start_container_cmd = "cd $container_compose_path && $type_container-compose up -d && $type_container start $container_name";
        shell_exec($create_and_start_container_cmd);

        // Attendre quelques secondes pour que le conteneur démarre complètement
        sleep(5);

        // Vérifier si le conteneur est en cours d'exécution
        $check_container_status_cmd = "$type_container inspect --format={{.State.Status}} $container_name";
        $container_status = trim(shell_exec($check_container_status_cmd));

        // Afficher le statut du conteneur
        $this->printMessage("Statut du conteneur : $container_status");

        // Si le conteneur n'est pas en cours d'exécution, afficher un message d'erreur
        if ($container_status !== "running") {
            $this->printMessage("Erreur : Le conteneur n'est pas en cours d'exécution. Vérifiez le journal pour plus d'informations.");
        }
        else {
            // Exécuter la commande dans le conteneur
            $exec_cmd = "start $type_container exec -it $container_name $image_name $command";
            $output = shell_exec($exec_cmd);

            // create image from container
            // $this->create_image_from_container($container_name, "{$container_name}_image");

            // Afficher la sortie de la commande
            $this->printMessage("Sortie de la commande :\n$output");
        }

        return true;

//        if(!$is_error){
//            $cmd = <<<CMD
//                cd $container_compose_path
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
//                $this->container_init($container_name,$image_name,$command, $container_compose_path, $type_container);
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
            $words = (json_decode($data??''))->response;

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