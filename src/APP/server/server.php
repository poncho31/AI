<?php

namespace GillesPinchart\Ai\APP\server;

class server
{
    public  function web_server(string $path_base_project = __DIR__,string $path_index_file="public/index.php", string $type = 'php', string $package_path ="\packages\php\php-8.3.2-nts"): void
    {
        $index_path = $path_base_project. "\\". $path_index_file;
        switch ($type){
            case 'php':
                $package_path = "$path_base_project$package_path";
                $this->php_web_server($index_path, $package_path);
                break;
            default:
                echo "Le web server $type n'existe pas.";
        }
    }
    public function php_web_server(string $path_index_file, ?string $php_path): void
    {
        $cmd = <<<CMD
            @echo off
            set "host=localhost:666"
            start "" "http://%host%"
            
            REM PHP VERSION
            $php_path/php.exe -v
            $php_path/php.exe -S %host% -t . $path_index_file
        CMD;

        $path = __DIR__."/web_server_php.bat";
        file_put_contents($path, $cmd);
        exec($path);
    }
}