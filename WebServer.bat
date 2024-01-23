@echo off
cd /d %~dp0
cd packages\php\php-8.3.2-nts
set "host=localhost:666"
start "" "http://%host%"
php -S %host% -t . ..\..\..\public\index.php
REM php -S localhost:666 -t . ..\..\..\src\api\ollama_api.php
