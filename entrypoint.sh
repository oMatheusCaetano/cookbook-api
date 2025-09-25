#!/bin/sh
composer install

php artisan migrate:fresh --seed

exec apache2-foreground
