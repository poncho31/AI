    @echo off
    set "host=localhost:666"
    start "" "http://%host%"
    
    REM PHP VERSION
    K:\projet\AI\packages\php\php-8.3.2-nts/php.exe -v
    K:\projet\AI\packages\php\php-8.3.2-nts/php.exe -S %host% -t . K:\projet\AI\AI