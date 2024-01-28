<?php

namespace GillesPinchart\Ai\APP\web\routes;

use GillesPinchart\Ai\APP\web\resources\view;
use GillesPinchart\Ai\constructors\Router;

class routes extends Router
{

/** WEB ROUTES **/

    /**
     *  MODIFIER ICI LA REDIRECTION DES ROUTES
     * @param string|null $route
     * @return route_model|array
     */
    public function web_routes(?string $route = null): route_model|array
    {
        // SELECT ROUTE
        if ($route == '404') {
            return $this->web_route('get', "/$route", "$route");
        }

        // ROUTES
        $this->web_route('get',  "/",      "homepage");
        $this->web_route('get',  "/api",   "api");
        $this->web_route('get', "/404", "404");


        return $this->web_routes;
    }


    public function init_web_routes(): void
    {
        // Init
        $is404 = true;

        // méthode simple qui sera lente au plus il y aura de routes = VOIR : init_routes_temp() !!!
        foreach ($this->web_routes() as $route){
            if($route->route_url === $_SERVER['REQUEST_URI']){
                // Inclu le fichier traité dans la vue
                include $route->route_path;
                $is404 = false;
            }
        }
        if($is404){
            include $this->web_routes('404')->route_path;
        }
    }


    /**
     * @param string $method
     * @param string $url
     * @param string $view
     * @param string $name
     * @return void
     */
    private function web_route(string $method, string $url, string $view, string $name =""): route_model
    {
        $route = new route_model();
        $route->route_name   = $name;
        $route->route_url    = $url;
        $route->route_view   = view::page($view);
        $route->route_path   = view::path($view);
        $route->route_method = $method;

        $this->web_routes [] = $route;
        return $route;
    }




/** API ROUTES **/
    public function api_routes(): array
    {
        // $this->api_route('get',  "/api",      "home","web_home_page");
        return $this->api_routes;
    }

    private function api_route(string $method, string $url, string $view, string $name =""): void
    {
        $route = new route_model();
        $route->route_type   = 'api';
        $route->route_name   = $name;
        $route->route_url    = $url    ;
        $route->route_view   = view::page($view);
        $route->route_method = $method;

        $this->api_routes [] = $route;
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