:loop
cd C:\laragon\www\collection-hub
C:\laragon\bin\php\php-7.3.26-Win32-VC15-x64\php.exe artisan queue:work 1>> NUL 2>&1
goto :loop