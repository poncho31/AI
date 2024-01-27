<?php

namespace GillesPinchart\Ai\APP\shortcut;

class storage
{
    public static function path(string $path = ""): string
    {
        return self::check_file_exist(__DIR__."/storage/$path");

    }

    public static function temp_path(string $path = ""): string
    {
        return self::path("temp/$path");
    }

    private static function check_file_exist($filePath){
        if(!file_exists($filePath)){
            $dirname = dirname($filePath);
            mkdir($dirname,0777, true);
        }
        return $filePath;
    }
}