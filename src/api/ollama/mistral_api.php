<?php

namespace GillesPinchart\Ai\api\ollama;

use GillesPinchart\Ai\api\api;

class mistral_api extends api
{
    public function start(?string $prompt =null, bool $is_streaming = true): void
    {
        $this->docker_init('ollamaContainer', 'ollama', 'run mistral',  __DIR__."\\docker-compose.yaml");
        $prompt = $prompt ?? "Pourquoi le ciel est bleu ?";

        $apiUrl    = 'http://localhost:11434/api/generate';
        $data      = $this->data_post_fields($prompt, $is_streaming);

        $this->printMessage("Votre question : $prompt", "title");

        $this->curl_streaming($apiUrl, $data);
    }

    public function data_post_fields($prompt, $streaming): bool|string
    {
        $data = json_encode([
            "model"           => "mistral",
            "prompt"          => $prompt,
            "stream"          => $streaming,
            "temperature"     => 1, // The temperature of the model. Increasing the temperature will make the model answer more creatively. (Default: 0.8)
            // "images"         => null, // Certain modele d'ia comme llava nécessite l'entrée d'une image en base64 ?
            "mirostat"       => 0, // Enable Mirostat sampling for controlling perplexity. (default: 0, 0 = disabled, 1 = Mirostat, 2 = Mirostat 2.0)
            "mirostat_eta"    => 0.1, // Influences how quickly the algorithm responds to feedback from the generated text. A lower learning rate will result in slower adjustments, while a higher learning rate will make the algorithm more responsive. (Default: 0.1)
            "mirostat_tau"   => 5.0, // Controls the balance between coherence and diversity of the output. A lower value will result in more focused and coherent text. (Default: 5.0)
            "num_ctx"        => 2048, // Sets the size of the context window used to generate the next token. (Default: 2048)
            // "num_gqa"        => null, // The number of GQA groups in the transformer layer. Required for some models, for example it is 8 for llama2:70b
            "num_gpu"        => 50, // The number of layers to send to the GPU(s). On macOS it defaults to 1 to enable metal support, 0 to disable. Ex: num_gpu 50
            "num_thread"     => 10 ,  // Sets the number of threads to use during computation. By default, Ollama will detect this for optimal performance. It is recommended to set this value to the number of physical CPU cores your system has (as opposed to the logical number of cores).
            "repeat_last_n"  => 64, // Sets how far back for the model to look back to prevent repetition. (Default: 64, 0 = disabled, -1 = num_ctx)
            "repeat_penalty" => 1.1, // Sets how strongly to penalize repetitions. A higher value (e.g., 1.5) will penalize repetitions more strongly, while a lower value (e.g., 0.9) will be more lenient. (Default: 1.1)
            "seed"           => 0, // Sets the random number seed to use for generation. Setting this to a specific number will make the model generate the same text for the same prompt. (Default: 0)
            // "stop"           => null, // Sets the stop sequences to use. When this pattern is encountered the LLM will stop generating text and return. Multiple stop patterns may be set by specifying multiple separate stop parameters in a modelfile. Ex : stop "AI assistant:"
            "tfs_z"          => 1, // Tail free sampling is used to reduce the impact of less probable tokens from the output. A higher value (e.g., 2.0) will reduce the impact more, while a value of 1.0 disables this setting. (default: 1)
            "num_predict"    => 128, // Maximum number of tokens to predict when generating text. (Default: 128, -1 = infinite generation, -2 = fill context)
            "top_k"          => 40, // Reduces the probability of generating nonsense. A higher value (e.g. 100) will give more diverse answers, while a lower value (e.g. 10) will be more conservative. (Default: 40)
            "top_p"          => 0.9, // Works together with top-k. A higher value (e.g., 0.95) will lead to more diverse text, while a lower value (e.g., 0.5) will generate more focused and conservative text. (Default: 0.9)
        ]);
        return $data;
    }
}