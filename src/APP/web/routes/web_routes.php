<?php

namespace php\ai\APP\web\routes;

use php\ai\APP\web\resources\view;

class web_routes
{
    public array $web_routes = [];

    /** WEB ROUTES **/

    /**
     *  MODIFIER ICI LA REDIRECTION DES ROUTES
     * @param string|null $route
     * @return route_model|array
     */
    public function web_routes(?string $route = null): route_model|array
    {
        // SELECT ROUTE
        if ($route !== null) {
            return $this->web_route('get', "/$route", "$route");
        }

        // ROUTES
        $this->web_route('get',  "/",       "chatbot");
        $this->web_route('get',  "/example","example");
        $this->web_route('get',  "/404",    "404");


        return $this->web_routes;
    }

    public function get_web_routes(): void
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
     * @return route_model
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

    public function calculate($chiffre1, $chiffre2)
    {
        $calcul = $chiffre1 * $chiffre2;
    }
}