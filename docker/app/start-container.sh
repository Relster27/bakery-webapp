#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ]; then
    cp .env.example .env
fi

mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/testing
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi

echo "Waiting for database at ${DB_HOST:-mysql}:${DB_PORT:-3306}..."
php -r '
$host = getenv("DB_HOST") ?: "mysql";
$port = (int) (getenv("DB_PORT") ?: 3306);
$deadline = time() + 120;
while (time() < $deadline) {
    $socket = @fsockopen($host, $port, $errno, $errstr, 2);
    if ($socket) {
        fclose($socket);
        exit(0);
    }
    sleep(2);
}
fwrite(STDERR, "Database connection timeout.\n");
exit(1);
'

php artisan optimize:clear
php artisan migrate --force

exec "$@"
