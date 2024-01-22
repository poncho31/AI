@echo off
cd /d %~dp0
cd packages\php\php-8.3.2-nts
php -S localhost:666 -t . ..\..\..\public\index.php
REM php -S localhost:666 -t . ..\..\..\src\api\ollama_api.php
