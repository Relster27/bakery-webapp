#!/bin/sh
set -e

cd /var/www/html

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  Bakery App — Container Startup"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# ─────────────────────────────────────────────
# 1. Scaffold required directories
# ─────────────────────────────────────────────
echo "📁 Creating storage directories..."
mkdir -p \
    storage/app/public/products \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/testing \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

# ─────────────────────────────────────────────
# 2. Seed images — copy from baked-in location
#    into the mounted storage volume (only if
#    they don't already exist there).
# ─────────────────────────────────────────────
if [ -d /docker-seed-images ] && [ "$(ls -A /docker-seed-images 2>/dev/null)" ]; then
    echo "🖼️  Copying seed product images into storage..."
    cp -rn /docker-seed-images/. storage/app/public/products/ 2>/dev/null || true
    chown -R www-data:www-data storage/app/public/products
    echo "✅ Seed images ready."
fi

# ─────────────────────────────────────────────
# 3. Override .env DB settings from docker-compose
#    environment (APP_KEY is already baked in)
# ─────────────────────────────────────────────
if [ -n "$DB_HOST" ]; then
    sed -i "s|^DB_HOST=.*|DB_HOST=${DB_HOST}|" .env
    sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE}|" .env
    sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME}|" .env
    sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|" .env
fi

if [ -n "$APP_URL" ]; then
    sed -i "s|^APP_URL=.*|APP_URL=${APP_URL}|" .env
fi

# ─────────────────────────────────────────────
# 4. Wait for MySQL to be ready
# ─────────────────────────────────────────────
echo "⏳ Waiting for MySQL at ${DB_HOST:-mysql}:${DB_PORT:-3306}..."
php -r '
$host    = getenv("DB_HOST") ?: "mysql";
$port    = (int)(getenv("DB_PORT") ?: 3306);
$deadline = time() + 120;
while (time() < $deadline) {
    $sock = @fsockopen($host, $port, $errno, $errstr, 2);
    if ($sock) { fclose($sock); exit(0); }
    sleep(2);
}
fwrite(STDERR, "ERROR: MySQL connection timeout after 120s.\n");
exit(1);
'
echo "✅ MySQL is ready."

# ─────────────────────────────────────────────
# 5. Clear config cache (picks up new env vars)
# ─────────────────────────────────────────────
php artisan config:clear
php artisan cache:clear

# ─────────────────────────────────────────────
# 6. Run migrations
# ─────────────────────────────────────────────
echo "🔄 Running migrations..."
php artisan migrate --force
echo "✅ Migrations complete."

# ─────────────────────────────────────────────
# 7. Seed demo data (idempotent — safe to run
#    every boot since seeder uses updateOrCreate)
# ─────────────────────────────────────────────
echo "🌱 Seeding demo data..."
php artisan db:seed --force
echo "✅ Seeding complete."

# ─────────────────────────────────────────────
# 8. Create public storage symlink
#    (makes /public/storage → storage/app/public)
# ─────────────────────────────────────────────
echo "🔗 Linking storage..."
php artisan storage:link --force 2>/dev/null || true
echo "✅ Storage linked."

# ─────────────────────────────────────────────
# 9. Optimize for production
# ─────────────────────────────────────────────
php artisan optimize

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  ✅ App ready at ${APP_URL:-http://localhost:8088}"
echo "  Login: owner@bakery.test / password"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# ─────────────────────────────────────────────
# 10. Start Apache
# ─────────────────────────────────────────────
exec "$@"
