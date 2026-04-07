@echo off
setlocal

echo Checking MySQL connection on 127.0.0.1:3306...
powershell -NoProfile -Command "$check = Test-NetConnection -ComputerName 127.0.0.1 -Port 3306 -WarningAction SilentlyContinue; if ($check.TcpTestSucceeded) { exit 0 } else { exit 1 }"

if errorlevel 1 (
    echo.
    echo MySQL is not reachable on 127.0.0.1:3306.
    echo Start MySQL in XAMPP first.
    echo If your MySQL uses a different port, change DB_PORT in .env.
    echo.
    pause
    exit /b 1
)

echo.
echo Running safe database migration and seed...
echo This will keep existing tables and only apply missing migrations.
php artisan migrate --seed

if errorlevel 1 (
    echo.
    echo Database setup failed.
    echo Check these items:
    echo 1. MySQL is running in XAMPP.
    echo 2. The database bakery_webapp already exists.
    echo 3. Close phpMyAdmin tabs that are browsing bakery_webapp tables if you were using them.
    echo 4. Stop any older php artisan serve or migrate commands still running.
    echo 5. DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD in .env are correct.
    echo.
    pause
    exit /b 1
)

echo.
echo Clearing Laravel cache...
php artisan optimize:clear

if errorlevel 1 (
    echo.
    echo Cache clear failed.
    pause
    exit /b 1
)

echo.
echo Starting Laravel development server...
echo Open this exact URL after the server starts: http://127.0.0.1:8001/login
php artisan serve --host=127.0.0.1 --port=8001
