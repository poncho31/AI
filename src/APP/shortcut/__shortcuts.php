<?php

use php\ai\APP\shortcut\debug;
use php\ai\APP\shortcut\env;
use php\ai\APP\shortcut\storage;
use JetBrains\PhpStorm\NoReturn;

// Debug
#[NoReturn] function dd($data, $echo=false, $stop = true): void{debug::dd($data, $echo, $stop);}

// Env
function env(string$key, ?string $value = null): string{return env::get($key, $value);}

// Storage
function storage_path(?string$path=""): string{return storage::path($path);}
function temp_path(?string$path=""): string{return storage::temp_path($path);}
