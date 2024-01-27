<?php
use GillesPinchart\Ai\APP\web\routes\routes;

require_once(__DIR__ . '/../base_app.php');

$routes = new routes();
$routes->init_routes();
