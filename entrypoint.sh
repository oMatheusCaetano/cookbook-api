#!/bin/sh

echo "===> Installing composer dependencies..."
composer install

echo "===> Running database migrations..."
php artisan migrate:fresh --seed

echo "===> Starting Apache server..."
exec apache2-foreground
