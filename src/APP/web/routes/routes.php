<?php

namespace GillesPinchart\Ai\APP\web\routes;

class routes
{

    public function display_routes(): void
    {
        if(str_contains($_SERVER['REQUEST_URI'], 'ai/api')){
            header('Content-Type: application/json');
            (new api_routes())->display_api_routes();
        }
        else{
            (new web_routes())->display_web_routes();
        }
    }











    public function init_routes_temp(string $base_dir = __DIR__): void
    {
        $bootstrap_path = "$base_dir/storage/bootstrap/";
        foreach ($this->web_routes() as $route) {
            dd($route);
        }
    }


    public function routes(): array
    {
        return [
            'web'=> $this->web_routes(),
            'api'=> $this->api_routes()
        ];
    }
}