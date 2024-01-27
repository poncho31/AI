<?php

namespace GillesPinchart\Ai\APP\web\routes;

use GillesPinchart\Ai\APP\web\resources\views;
use GillesPinchart\Ai\constructors\Router;

class routes extends Router
{

    /**
     *  MODIFIER ICI LA REDIRECTION DES ROUTES
     * @return array
     */
    public function web_routes(): array
    {
        // Homepage
        $this->web_route('get',  "/",     views::HomePage(),"web_home_page");
        $this->web_route('post', "/home", "home",     "web_home_page");

        return $this->web_routes;
    }

    public function api_routes(): array
    {
        $this->api_route('get',  "/api",      "home","web_home_page");
        $this->api_route('post', "/api/home", "home","web_home_page");
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
        $route->route_view   = "$this->viewsPath/$view";
        $route->route_method = $method;

        $this->web_routes [] = $route;
    }

    private function api_route(string $method, string $url, string $view, string $name =""): void
    {
        $route = new route_model();
        $route->route_type   = 'api';
        $route->route_name   = $name;
        $route->route_url    = $url    ;
        $route->route_view   = "$this->viewsPath/$view";
        $route->route_method = $method;

        $this->api_routes [] = $route;
    }
}