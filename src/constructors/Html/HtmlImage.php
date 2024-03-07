<?php

namespace php\ai\constructors\Html;

class HtmlImage extends Html
{
    public static string $image_path = "K:/projet/AI/storage/app/images";
    public static function add($image): void
    {
        echo "data:image/png;base64, ".base64_encode(file_get_contents(self::$image_path."/$image"));
    }
}