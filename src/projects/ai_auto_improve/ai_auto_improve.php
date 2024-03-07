<?php
namespace php\ai\projects\ai_auto_improve;

use Exception; // For error handling

class ai_auto_improve{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        $fichierServer                = __DIR__."\project\ChatBotApp";

        // Exemple d'utilisation
        startStreaming("php -S localhost:666 -t {$fichierServer}");

        // Pour arrêter le streaming, utilisez la fonction stopStreaming()
        stopStreaming();


        // $executeWebServer             = exec("start php -S localhost:666 -t {$fichierServer}", $output);
        // streamTerminal("start /b php -S localhost:666 -t {$fichierServer}");
        echo "test";
        // dd($output);
        // dd($executeWebServer);
        // $serverData                   = trim($executeWebServer);
        // $this->analyze_output($serverData);
    }

    /**
     * @throws Exception
     */
    public function analyze_output($output): void
    {
        // Error handling and code analysis logic here
        if (str_contains($output, 'Exception')) {
            $error_message = explode(':', substr($output, strpos($output, ':'), strlen(substr($output,
                strpos($output, ':'))))[0]);
            throw new Exception(implode('',$error_message));
        }

        // Machine learning and AI logic here for understanding output or errors and suggesting improvements
        $suggestions = $this->learn_from_data($output);
        // Log the suggestions for later review or use in future iterations
        $this->log_results($suggestions);
    }

    public function learn_from_data($output){
        // Implement machine learning techniques or libraries here to analyze output/errors and suggestimprovements
        $suggestions = $output;
        return $suggestions; // Array of suggested fixes or improvements
    }

    public function log_results($results){
        // Logging system implementation here, which can store the results for further analysis by developers orfuture use
    }

}