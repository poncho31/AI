<?php

namespace GillesPinchart\Ai\database;

use Exception;
use GillesPinchart\Ai\APP\shortcut\env;
use PDO;
use PDOException;
use SQLite3;
use SQLite3Result;

class Sqlite
{
    private SQLite3 $db;

    public function __construct($dbName, ?string $dir = null) {
        chdir($dir ?? "./storage/database");
        $this->db = new SQLite3("$dbName.db");
    }

    public function get(string $query): array
    {
        $data   = $this->db->query($query);
        $result = [];
        while ($row = $data->fetchArray(SQLITE3_ASSOC)) {
            $result[] = $row;
        }
        return $result;
    }

    public function first(string $query){
        return $this->db->querySingle($query, true);
    }


    public function create_table(string $tableName, array $fields): bool|SQLite3Result
    {
        $tableString = "";
        foreach ($fields as $key => $value) {
            $tableString .= " $key $value ";
            if ($key !== array_key_last($fields)) {
                $tableString .= " ,\n " ;
            }
        }
        $query = "CREATE TABLE IF NOT EXISTS $tableName ($tableString)";
        return $this->db->exec($query);
    }

    public function insert_table(string $tableName, array $data): bool {
        if(isset($data[0])){
            foreach ($data as $data_unique){
                try{
                    $this->insert_table($tableName, $data_unique);
                }
                catch (Exception $e){

                }
            }
        }
        else{
            $keys = implode(", ", array_keys($data));
            $values = "'" . implode("', '", array_values($data)) . "'";
            $query = "INSERT INTO $tableName ($keys) VALUES ($values)";
            return $this->db->exec($query);
        }
        return 1;
    }

    public function init_environment_variables(): void
    {
        $this->create_table(
            "ai_env",
            [
                "key"    => "TEXT UNIQUE",
                "value"  => "TEXT",
            ]
        );

        foreach (Env::get() as $key => $value){
            $this->insert_table("ai_env",
                [
                    [
                        "key"   => $key,
                        "value" => $value,
                    ]
                ]
            );
        }
    }

    public function init_ai_table(): void
    {
        $this->create_table(
            "ai_api",
            [
                "name"                   => "TEXT UNIQUE",

                "container_name"         => "TEXT",
                "container_type"         => "TEXT",
                "port"                   => "TEXT UNIQUE",

                "image_name"             => "TEXT",
                "image_package"          => "TEXT",
                "image_container_name"   => "TEXT",

                "volume_name"            => "TEXT",
                "volume_path_docker"     => "TEXT",
                "volume_path_os"         => "TEXT",

                "docker_compose_version" => "TEXT",

                "command"                => "TEXT",

                "api_url"                => "TEXT",
                "api_data_post_field"    => "TEXT",
            ]
        );

        $this->insert_table("ai_api",
            [
                // mistral
                [
                    "name"                   => "mistral",

                    "container_name"         => "ollama_mistral_container",
                    "container_type"         => "docker",

                    "port"                   => "11434:11434",

                    "image_name"             => "ollama",
                    "image_package"          => "ollama/ollama",
                    "image_container_name"   => "ollama_mistral_container_image",

                    "volume_name"            => "ollama_mistral_volume",
                    "volume_path_docker"     => "/usr/share/ollama/mistral/data",
                    "volume_path_os"         => 'K:\projet\AI\src\docker\ollama\volumes\ollama\mistral',

                    "docker_compose_version" => "3",

                    "command"                => "run mistral",

                    "api_url"               => "http://localhost:11434/api/generate",
                    "api_data_post_field"   =>
                        json_encode([
                            "model"          => "mistral",
                            "prompt"         => "Quel est la couleur du ciel ?",
                            "stream"         => true,
                            "temperature"    => 1,
                            "mirostat"       => 0,
                            "mirostat_eta"   => 0.1,
                            "mirostat_tau"   => 5.0,
                            "num_ctx"        => 2048,
                            "num_gpu"        => 50,
                            "num_thread"     => 10 ,
                            "repeat_last_n"  => 64,
                            "repeat_penalty" => 1.1,
                            "seed"           => 0,
                            "tfs_z"          => 1,
                            "num_predict"    => 128,
                            "top_k"          => 40,
                            "top_p"          => 0.9,
                        ])
                ],

                // TINY_DOLPHIN
                [
                    "name"                   => "tiny_dolphin",

                    "container_name"         => "ollama_tiny_dolphin_container",
                    "container_type"         => "docker",

                    "port"                   => "11435:11435",

                    "image_name"             => "ollama",
                    "image_package"          => "ollama/ollama",
                    "image_container_name"   => "ollama_tiny_dolphin_container_image",

                    "volume_name"            => "ollama_tiny_dolphin_volume",
                    "volume_path_docker"     => "/usr/share/ollama/tiny_dolphin/data",
                    "volume_path_os"         => 'K:\projet\AI\src\docker\ollama\volumes\ollama\tiny_dolphin',

                    "docker_compose_version" => "3",

                    "command"                => "run tinydolphin",

                    "api_url"               => "http://localhost:11435/api/generate",
                    "api_data_post_field"    =>
                        json_encode([
                            "model"          => "tinydolphin",
                            "prompt"         => "Quel est la couleur du ciel ?",
                            "stream"         => true,
                            "temperature"    => 1,
                            "mirostat"       => 0,
                            "mirostat_eta"   => 0.1,
                            "mirostat_tau"   => 5.0,
                            "num_ctx"        => 2048,
                            "num_gpu"        => 50,
                            "num_thread"     => 10 ,
                            "repeat_last_n"  => 64,
                            "repeat_penalty" => 1.1,
                            "seed"           => 0,
                            "tfs_z"          => 1,
                            "num_predict"    => 128,
                            "top_k"          => 40,
                            "top_p"          => 0.9,
                        ])
                ],

                // TINY DOLPHIN 1B
                [
                    "name"                   => "tiny_dolphin_1b",

                    "container_name"         => "ollama_tiny_dolphin_container",
                    "container_type"         => "docker",

                    "port"                   => "11436:11436",

                    "image_name"             => "ollama",
                    "image_package"          => "ollama/ollama",
                    "image_container_name"   => "ollama_tiny_dolphin_container_image",

                    "volume_name"            => "ollama_tiny_dolphin_volume",
                    "volume_path_docker"     => "/usr/share/ollama/tiny_dolphin/data",
                    "volume_path_os"         => 'K:\projet\AI\src\docker\ollama\volumes\ollama\tiny_dolphin',

                    "docker_compose_version" => "3",

                    "command"                => "run tinydolphin:1.1b-v2.8-q2_K",

                    "api_url"               => "http://localhost:11436/api/generate",
                    "api_data_post_field"   =>
                        json_encode([
                            "model"          => "tinydolphin:1.1b-v2.8-q2_K",
                            "prompt"         => "Quel est la couleur du ciel ?",
                            "stream"         => true,
                            "temperature"    => 1,
                            "mirostat"       => 0,
                            "mirostat_eta"   => 0.1,
                            "mirostat_tau"   => 5.0,
                            "num_ctx"        => 2048,
                            "num_gpu"        => 50,
                            "num_thread"     => 10 ,
                            "repeat_last_n"  => 64,
                            "repeat_penalty" => 1.1,
                            "seed"           => 0,
                            "tfs_z"          => 1,
                            "num_predict"    => 128,
                            "top_k"          => 40,
                            "top_p"          => 0.9,
                        ])
                ]
            ]
        );
    }
}