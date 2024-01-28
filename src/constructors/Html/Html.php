<?php

namespace GillesPinchart\Ai\constructors\Html;

use GillesPinchart\Ai\constructors\Css\Css;
use GillesPinchart\Ai\constructors\Javascript\Javascript;

class Html
{
    public static function begin(string $file=''): void
    {
        $title = "AI APP";
        $css   = Css::base();
        if($file==="error"){
            $css   = $css . Css::error404();
            $title = "$title : error 404";
        }

        $html = <<<HTML
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    $css
                    
                    <title>$title</title>
                </head>
                <body>


        HTML;
        echo $html;
    }

    public static function end(string $file =""): void
    {
        $js ="";
        if($file==='base'){
            $js    = Javascript::base() . Javascript::chat();
        }
        elseif($file==="error"){
            $js    = Javascript::base();
        }

        $html = <<<HTML
            $js
            </body>
            </html>
        HTML;
        echo  $html;
    }

    public static function echoOrReturn(callable $call ,bool $echo =true){
        if($echo){
            echo $call;
        }
        else{
            return $call;
        }
    }
}