<?php

namespace GillesPinchart\Ai\APP\server;

class server
{
    public  function web_server(string $path_base_project = __DIR__,string $path_index_file="public/index.php", string $type = 'php'): void
    {
        $index_path = $path_base_project. "/". $path_index_file;
        switch ($type){
            case 'php':
                $this->php_web_server($index_path);
                break;
            default:
                echo "Le web server $type n'existe pas.";
        }
    }
    public function php_web_server(string $path_index_file): void
    {

        $cmd = <<<CMD
            @echo off
            cd /d %~dp0
            cd packages\php\php-8.3.2-nts
            set "host=localhost:666"
            start "" "http://%host%"
            
            REM PHP VERSION
            php -v
            php -S %host% -t . $path_index_file
        CMD;

        $path = __DIR__."/web_server_php.bat";
        file_put_contents($path, $cmd);
        exec($path);
    }
}