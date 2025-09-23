#!/bin/sh
composer install

php artisan migrate

exec apache2-foreground
