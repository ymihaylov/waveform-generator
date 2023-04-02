#!/bin/bash

# Run composer install
composer install --no-scripts --no-dev

# Start the PHP built-in web server
php -S 0.0.0.0:80 -t /var/www/html
