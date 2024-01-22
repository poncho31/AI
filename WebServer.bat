@echo off
cd /d %~dp0
cd packages\php\php-8.3.2-nts
php -S localhost:8000 -t . ..\..\..\index.php