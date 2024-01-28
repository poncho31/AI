<?php

namespace GillesPinchart\Ai\constructors\Html;

use GillesPinchart\Ai\constructors\Css\Css;
use GillesPinchart\Ai\constructors\Javascript\Javascript;

class Html
{
    public static function begin(string $file=''): void
    {
        $css = '';
        if($file==='base'){
            $css   = Css::base();
        }
        elseif($file==="error"){
            $css   = Css::error404();
        }

        $html = <<<HTML
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    
                    $css
                    
                    <title>ChatGPT Messenger</title>
                </head>
                <body>


        HTML;
        echo $html;
    }

    public static function end(): void
    {
        $js    = Javascript::base() . Javascript::chat();
        $html = <<<HTML
            $js
            </body>
            </html>
        HTML;
        echo  $html;
    }

    public static function style(): string
    {
        return "<style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        .illustration {
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            font-size: 3em;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>";
    }

    public static function javascript(){

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