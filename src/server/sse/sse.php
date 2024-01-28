<?php

namespace GillesPinchart\Ai\server\sse;

class sse
{
    public function __construct()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Access-Control-Allow-Origin: *');
    }

    public function sendSseMessage($id, $data, $event = 'message'): void
    {
        echo "id: $id" . PHP_EOL;
        echo "event: $event" . PHP_EOL;
        echo "data: $data" . PHP_EOL;
        echo PHP_EOL;

        // echo json_encode(['id'=>$id,'event'=>$event,'data'=>$data]);
        ob_flush();
        flush();
    }

    public function start(): void
    {
        $counter = 0;

        // $postData = file_get_contents("php://input");
        $data = ['SERVER'=>$_SERVER, 'POST'=>$_POST, 'GET'=>$_GET, 'ENV'=>$_ENV, 'REQUEST'=>$_REQUEST, 'COOKIES'=>$_COOKIE, 'SESSIONS'=>$_SESSION??null, 'FILES'=>$_FILES];
        $this->sendSseMessage($counter, json_encode($data), 'test_event');
        sleep(1);

        // while (true) {
        //     // Traitement de la requête POST (vous pouvez ajouter votre logique ici)
        //     $postData = file_get_contents("php://input");
        //     $this->sendSseMessage($counter, "Received POST data: $postData", 'post_event');
        //     $counter++;
        //     // Simule une attente d'une seconde
        //     sleep(1);
        //     return;
        // }
    }
}
