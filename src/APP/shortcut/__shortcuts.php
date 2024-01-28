<?php

use GillesPinchart\Ai\APP\shortcut\debug;
use GillesPinchart\Ai\APP\shortcut\storage;
use JetBrains\PhpStorm\NoReturn;

// Debug
#[NoReturn] function dd($data, $echo=false): void{debug::dd($data, $echo);}

// Storage
function storage_path(?string$path=""): string{return storage::path($path);}
function temp_path(?string$path=""): string{return storage::temp_path($path);}
