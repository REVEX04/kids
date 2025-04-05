<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Setup : Kids Laravel Website

1. install [laragon-wamp.exe](https://github.com/leokhoa/laragon/releases/download/6.0.0/laragon-wamp.exe)
2. extract [php-8.4.5-nts-Win32-vs17-x64.zip](tools/php-8.4.5-nts-Win32-vs17-x64.zip) in C:\laragon\bin\php
3. install [Composer-Setup.exe](tools/Composer-Setup.exe)
4. choose C:\laragon\bin\php\php-8.4.5-nts-Win32-vs17-x64\php.exe for **Composer Setup**
5. `composer install`
6. `php artisan migrate`
7. `php artisan db:seed`
8. `php artisan serve`
