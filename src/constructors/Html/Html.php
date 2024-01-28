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

        switch ($file){
            case 'error' :
                $css   = $css . Css::error404();
                $title = "$title : error 404";
                break;
            case 'api' :
                $css   = $css . Css::api();
                $title = "$title : API";
                break;
            default:
                $title = "$title : chat bot";
                $css = $css . Css::chat_bot();
                break;
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
        $js    = Javascript::base();
        switch ($file){
            case 'error' :
                $js    = "";
                break;
            case 'api' :
                $js    = " ";
                break;
            default:
                $js    = $js . Javascript::chat();
                break;
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