<?php

namespace GillesPinchart\Ai\APP\web\routes;

use GillesPinchart\Ai\APP\web\resources\view;

class api_routes
{
    public array $api_routes = [];

    /** API ROUTES **/
    public function api_routes(?string $route = null): route_model|array
    {
        // SELECT ROUTE
        if ($route !== null) {
            return $this->api_route('get', "/$route", "$route");
        }

        // API ROUTES
        $this->api_route('get',"/ai/api/doc",    "api/doc",    "api_doc");
        $this->api_route('get',"/ai/api/mistral","api/ai/mistral","api_mistral");

        return $this->api_routes;
    }


    public function get_api_route(): void
    {
        // Init
        $is404 = true;

        // méthode simple qui sera lente au plus il y aura de routes = VOIR : init_routes_temp() !!!
        foreach ($this->api_routes() as $route){
            if($route->route_url === $_SERVER['REQUEST_URI']){
                // Inclu le fichier traité dans la vue
                include $route->route_path;
                $is404 = false;
            }
        }
        if($is404){
            include $this->api_routes('api/404')->route_path;
        }
    }

    /**
     * @param string $method
     * @param string $url
     * @param string $view
     * @param string $name
     * @return route_model
     */
    private function api_route(string $method, string $url, string $view, string $name =""): route_model
    {
        $route = new route_model();
        $route->route_type   = 'api';
        $route->route_name   = $name;
        $route->route_url    = $url    ;
        $route->route_view   = view::page($view);
        $route->route_path   = view::path($view, 'api');
        $route->route_method = $method;


        $this->api_routes [] = $route;
        return $route;
    }
}