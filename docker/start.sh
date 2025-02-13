#!/bin/bash

echo "Running composer install..."
composer install --no-dev --optimize-autoloader

echo "Running npm install..."
npm install

# echo "Starting PHP-FPM..."
# php-fpm

echo "Starting PHP-FPM..."
service nginx start

# Iniciar PHP-FPM no modo foreground
php-fpm -F

