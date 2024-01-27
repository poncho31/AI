<?php

use GillesPinchart\Ai\APP\shortcut\debug;
use GillesPinchart\Ai\APP\shortcut\storage;
use JetBrains\PhpStorm\NoReturn;

// Debug
#[NoReturn] function dd($data): void{debug::dd($data);}

// Storage
function storage_path(?string$path=""): void{storage::path($path);}
function temp_path(?string$path=""): void{storage::temp_path($path);}
