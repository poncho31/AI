<?php

namespace GillesPinchart\Ai\server\sse;

class sse
{
    public function __construct()
    {
        // Autoriser les requêtes depuis n'importe quel domaine
        header('Access-Control-Allow-Origin: *');

        // D'autres en-têtes CORS optionnels
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Access-Control-Max-Age: 86400'); // Cache les résultats des pré-vérifications CORS pendant 1 jour


        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
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

    public function start()
    {
        $counter = 0;
        while (true) {
            // Traitement de la requête POST (vous pouvez ajouter votre logique ici)
            $postData = file_get_contents("php://input");
            $this->sendSseMessage($counter, "Received POST data: $postData", 'post_event');
            $counter++;
            // Simule une attente d'une seconde
            sleep(1);
            return;
        }
    }
}
