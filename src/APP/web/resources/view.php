<?php

namespace GillesPinchart\Ai\APP\web\resources;

class view
{
    public static bool  $use_include = true ;
    public static string $views_path = __DIR__. "\\views";

    public static function path(string $view): string
    {
        return self::$views_path."\\{$view}.view.php";
    }

    /**
     * @param string $view
     * @param bool $auto_create
     * @return false|string
     */
    public static function page(string $view, bool $auto_create=false): bool|string
    {
        $path = self::path($view);

        // Création vue (mode create) Ou 404 error
        if(!file_exists($path)){
            if($auto_create){
                file_put_contents($path, "Veuillez inclure votre code ici pour la vue <b>$view</b>");
            }
            else{
                $path = self::$views_path."\\404.view.php";;
            }
        }

        // Mode de retour (include bug pour l'instant)
        if(self::$use_include){
            return $path;
        }
        else{
            return file_get_contents($path);
        }
    }
}