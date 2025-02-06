#!/bin/bash

echo "Running composer install..."
composer install --no-dev --optimize-autoloader

echo "Running npm install..."
npm install

echo "Starting PHP-FPM..."
php-fpm

echo "Laravel Started!"