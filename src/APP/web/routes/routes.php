<?php

namespace GillesPinchart\Ai\APP\web\routes;

use GillesPinchart\Ai\APP\web\resources\view;
use GillesPinchart\Ai\constructors\Router;

class routes extends Router
{
    /**
     *  MODIFIER ICI LA REDIRECTION DES ROUTES
     * @return array<route_model>
     */
    public function web_routes(): array
    {
        // Homepage
        $this->web_route('get',  "/",     view::page("homepage"),"web_home_page");
        $this->web_route('get',  "/api",  view::page("api"),     "api_page");

        return $this->web_routes;
    }

    public function api_routes(): array
    {
        // $this->api_route('get',  "/api",      "home","web_home_page");
        return $this->api_routes;
    }

    public function routes(): array
    {
        return [
            'web'=> $this->web_routes(),
            'api'=> $this->api_routes()
        ];
    }

    /**
     * @param string $method
     * @param string $url
     * @param string $view
     * @param string $name
     * @return void
     */
    private function web_route(string $method, string $url, string $view, string $name =""): void
    {
        $route = new route_model();
        $route->route_name   = $name;
        $route->route_url    = $url    ;
        $route->route_view   = $view;
        $route->route_method = $method;

        $this->web_routes [] = $route;
    }

    private function api_route(string $method, string $url, string $view, string $name =""): void
    {
        $route = new route_model();
        $route->route_type   = 'api';
        $route->route_name   = $name;
        $route->route_url    = $url    ;
        $route->route_view   = $view;
        $route->route_method = $method;

        $this->api_routes [] = $route;
    }


    public function init_routes(): void
    {
        // méthode simple qui sera lente au plus il y aura de routes = VOIR : init_routes_temp() !!!
        foreach ($this->web_routes() as $route){
            if($route->route_url === $_SERVER['REQUEST_URI']){
                echo $route->route_view;
            }
        }
    }

    public function init_routes_temp(string $base_dir = __DIR__): void
    {
        $bootstrap_path = "$base_dir/storage/bootstrap/";
        foreach ($this->web_routes() as $route) {
            dd($route);
        }
    }
}