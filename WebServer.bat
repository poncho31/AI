@echo off
cd /d %~dp0
cd packages\php\php-8.3.2-nts
set "host=localhost:666"

set "indexFilePath=%1"
if "%indexFilePath%"=="" (
    set "indexFilePath=..\..\..\public\index.php"
)

start "" "http://%host%"

REM PHP VERSION
php -v
php -S %host% -t . %indexFilePath%
REM php -S localhost:666 -t . ..\..\..\src\api\ollama_api.php
