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
        while (true) {
            // Traitement de la requête POST (vous pouvez ajouter votre logique ici)
            $postData = file_get_contents("php://input");
            $this->sendSseMessage($counter, "Received POST data: $postData", 'post_event');
            $counter++;
            // Simule une attente d'une seconde
            sleep(1);
        }
    }
}
