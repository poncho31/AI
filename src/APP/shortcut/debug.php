<?php

namespace php\ai\APP\shortcut;

// Fonctions de débugages
use JetBrains\PhpStorm\NoReturn;

class debug
{
    public static array $colors = [
        'text-green'  =>32,
        'text-red'    =>31,
        'text-orange' =>33,

        'bck-violet'  =>45,
    ];

    #[NoReturn] public static function dd($data, $echo = false, bool $stop = true): void
    {
        $color = debug::$colors['text-green'];
        if(is_string($data)){
            $color = debug::$colors['text-orange'];
        }
        elseif(is_int($data) || is_float($data)){
            $color = debug::$colors['text-red'];
            $data  = print_r($data, true);
        }
        else{
            $data  = print_r($data, true);
        }


        if($echo){
            echo "<pre>".htmlspecialchars(print_r($data, true))."</pre>";
        }
        else{
            echo "[1;{$color}m" .  $data . "[0m";

        }

        if($stop){
            die();
        }
    }

}