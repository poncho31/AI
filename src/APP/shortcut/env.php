<?php

namespace GillesPinchart\Ai\APP\shortcut;

class env
{
    public static function get(?string$key=null, ?string $value = null): null|string|array
    {
        $env = (new env)->parseEnv((new env)->root_path()."\\.env");
        return $key== null ? $env : ($env[$key]??null);
    }

    private function parseEnv($filePath): array
    {
        $envContent = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $envVariables = [];

        foreach ($envContent as $line) {
            // Ignore lines starting with '#' (comments) and empty lines
            if (str_starts_with(trim($line), '#') || empty($line)) {
                continue;
            }

            // Split the line into key and value
            list($key, $value) = explode('=', $line, 2);

            // Remove quotes from the value if present
            $value = trim($value, '"');

            // Store key-value pair in the array
            $envVariables[$key] = trim($value, "'");
        }

        return $envVariables;
    }

    public function root_path(): string
    {
        $driveName  = explode(':', __DIR__)[0];
        return "$driveName:\\{$_SERVER['SCRIPT_FILENAME']}";
    }

}