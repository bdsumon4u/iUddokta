#!/bin/sh

echo "Deploying application..."

/opt/alt/php82/usr/bin/php artisan down || true
git pull origin master
/opt/alt/php82/usr/bin/php /opt/cpanel/composer/bin/composer install --no-interaction --prefer-dist --optimize-autoloader --no-progress --no-dev
/opt/alt/php82/usr/bin/php artisan migrate --force
/opt/alt/php82/usr/bin/php artisan optimize
/opt/alt/php82/usr/bin/php artisan up

echo "Application deployed!"