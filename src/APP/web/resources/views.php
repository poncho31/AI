<?php

namespace GillesPinchart\Ai\APP\web\resources;

class views
{
    public array $views = [];

    public static function HomePage(): string
    {
        return file_get_contents(__DIR__. "\\views\\homepage.view.php");
    }
}