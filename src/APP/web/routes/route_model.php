<?php

namespace php\ai\APP\web\routes;

class route_model
{
    public string $route_type   = "web";
    public string $route_name   = "web_home_page";
    public string $route_url    = "/";
    public string $route_path   = "../view/index.php";
    public ?string $route_view   = "<?php echo 'TEST'; ?>>";
    public string $route_method = "";
}