<?php

namespace GillesPinchart\Ai\constructors;

use GillesPinchart\Ai\APP\web\routes\route_model;

class Router
{
    public array  $routes = [];
    public string $viewsPath = "../resources/views";
    /**
     * @var array
     */
    public array $web_routes = [];
    public array $api_routes = [];

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