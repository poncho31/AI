@echo off
set "root=%~dp0"
set "php_exec=%root%packages\php\php-8.3.2-nts\php-8.3.2-nts.exe"
set "app_path=%root%"

echo "%php_exec%"
echo "%app_path%"

%php_exec% %app_path%AI serve