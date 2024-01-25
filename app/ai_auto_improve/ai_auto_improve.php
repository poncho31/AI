<?php
namespace AI\app\ai_auto_improve;

class ai_auto_improve{
    public function run(){
        $fichierServer                = __DIR__."project/ChatBotApp/index.php";
        $executeWebServer             =  exec("php -s locahost:6666 $fichierServer");
        $serverData                   = $executeWebServer;
        $recupererLesErreursOuLeCode  = str_contains("Exception", $serverData);
        $analyserSiErreurOuCodeNormal = "";

    }
}