<?php

namespace GillesPinchart\Ai\APP\web\resources;

class view
{
    public static bool  $use_include = false ;
    public static string $views_path = __DIR__. "\\views";

    /**
     * @param $view
     * @return false|string|void
     */
    public static function page($view)
    {
        $path = self::$views_path."\\{$view}.view.php";

        if(self::$use_include){
            include $path;
        }
        else{
            return file_get_contents($path);
        }
    }
}