# Bakery Inventory & Ordering Web App

This is a Laravel web application for a Software Engineering college project.

The project folder is:

- `D:\SE\bakery-webapp`

This README is written for a beginner. It explains exactly what to click, what to type, and why you are doing each step.

## What this app already has

- Owner login and registration
- Bakery profile page
- Product and pricing management
- Inventory tracking
- Customer registration
- Counter sale creation
- Public pre-order page
- Order status tracking
- Order expiration with stock return
- Revenue ledger on the dashboard

## Important idea before starting

This app needs 3 things to run:

- The project files in `D:\SE\bakery-webapp`
- PHP and Composer
- MySQL running from XAMPP

Laravel is the PHP framework used by this project.

MySQL is the database. A database is simply a place where the app stores data such as:

- owner accounts
- bakery profile
- products
- inventory stock
- customers
- orders

When I say "create a database", I mean:

- open XAMPP tools
- create an empty container in MySQL
- give that container the name `bakery_webapp`
- then let Laravel create all the tables inside it automatically

You do not need to manually create tables one by one. Laravel will do that for you.

## Before you start

Make sure these are true:

1. XAMPP is installed.
2. PHP works in terminal.
3. Composer works in terminal.
4. This project is already in `D:\SE\bakery-webapp`.

If you want to check PHP and Composer, open PowerShell and run:

```powershell
php -v
composer --version
```

If both commands print version information, that part is okay.

## Step 1: Open the project folder

Open PowerShell.

Then go into the project folder:

```powershell
cd D:\SE\bakery-webapp
```

After that, every command in this README should be run from that folder.

## Step 2: Start XAMPP

1. Open `XAMPP Control Panel`.
2. Find the row named `Apache`.
3. Click `Start`.
4. Find the row named `MySQL`.
5. Click `Start`.

What you should see:

- Apache status becomes active
- MySQL status becomes active
- usually the row becomes green

If MySQL does not start, the database part of the app will not work.

## Step 3: Create the MySQL database

This is the part you asked about.

You need to create one empty database named `bakery_webapp`.

The easiest way is with phpMyAdmin.

### Method A: Create database using phpMyAdmin

1. Make sure `Apache` and `MySQL` are already started in XAMPP.
2. Open your browser.
3. Go to:

```text
http://localhost/phpmyadmin
```

4. Look for a button or menu named `New` on the left side.
5. Click `New`.
6. In the field for database name, type:

```text
bakery_webapp
```

7. For collation, if phpMyAdmin asks, choose:

```text
utf8mb4_unicode_ci
```

8. Click `Create`.

After that, the database exists.

Very important:

- You are only creating the database container here.
- The tables such as `products`, `orders`, and `customers` are not created yet.
- Laravel will create those tables in a later step using migrations.

### Method B: Create database using SQL tab in phpMyAdmin

If you prefer SQL:

1. Open `http://localhost/phpmyadmin`
2. Click `SQL`
3. Paste this:

```sql
CREATE DATABASE bakery_webapp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

4. Click `Go`

Either Method A or Method B is enough. You do not need both.

## Step 4: Check the `.env` file

The file `.env` stores local settings for your computer.

Open this file:

- `D:\SE\bakery-webapp\.env`

Make sure the database section looks like this:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bakery_webapp
DB_USERNAME=root
DB_PASSWORD=
```

What each line means:

- `DB_CONNECTION=mysql`
  Laravel should use MySQL, not SQLite.
- `DB_HOST=127.0.0.1`
  MySQL is running on your own computer.
- `DB_PORT=3306`
  This is the default MySQL port in XAMPP.
- `DB_DATABASE=bakery_webapp`
  This must match the database name you created in phpMyAdmin.
- `DB_USERNAME=root`
  XAMPP usually uses `root` by default.
- `DB_PASSWORD=`
  Empty means no password. This is normal for many XAMPP setups.

If your XAMPP MySQL uses a password, put it after `DB_PASSWORD=`.

Example:

```env
DB_PASSWORD=123456
```

## Step 5: Generate the application key

In PowerShell, still inside `D:\SE\bakery-webapp`, run:

```powershell
php artisan key:generate
```

What this does:

- Laravel needs a secret key for sessions and encryption.
- This command writes that key into `.env`.

What you should expect:

- a success message
- no error

## Step 6: Create the tables and sample data

Now run:

```powershell
php artisan migrate:fresh --seed
```

This is one of the most important commands.

What it does:

- `migrate`
  creates database tables
- `fresh`
  first deletes old tables if they already exist
- `seed`
  inserts sample data for testing

In simple words:

- Laravel will build the database structure for you
- then Laravel will insert demo data so the app is not empty

The command should create tables like:

- `users`
- `bakeries`
- `products`
- `inventories`
- `customers`
- `orders`
- `order_items`

It will also insert demo data, including a demo owner account.

If this command finishes without error, the database part is ready.

## Step 7: Start the Laravel server

Run:

```powershell
php artisan serve
```

What this does:

- starts a local development web server
- gives you a local URL to open in your browser

Usually Laravel will show something like:

```text
Server running on [http://127.0.0.1:8000]
```

Leave that PowerShell window open.

If you close it, the local server stops.

## Step 8: Open the app in your browser

Open:

```text
http://127.0.0.1:8000
```

The app should redirect you to the login page.

## Step 9: Login using the demo account

After `php artisan migrate:fresh --seed`, you can use this account:

- Email: `owner@bakery.test`
- Password: `password`

If login works, the setup is successful.

## Step 10: Important pages inside the app

After login, these pages matter most:

- `/dashboard`
  owner summary page
- `/products`
  manage bakery menu and prices
- `/inventories`
  manage stock numbers
- `/customers`
  manage customer data
- `/orders`
  create and track orders
- `/bakery/edit`
  bakery profile page

Public ordering page after seeding:

- `/menu/morning-crumbs-demo`

Full example link:

```text
http://127.0.0.1:8000/menu/morning-crumbs-demo
```

That page is the one a QR code should open later.

## One full example from zero

If you want the shortest exact sequence, this is it:

1. Open XAMPP.
2. Start Apache.
3. Start MySQL.
4. Open `http://localhost/phpmyadmin`.
5. Create a database named `bakery_webapp`.
6. Open PowerShell.
7. Run:

```powershell
cd D:\SE\bakery-webapp
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

8. Open `http://127.0.0.1:8000`
9. Login with:
   `owner@bakery.test`
   `password`

## If something goes wrong

### Problem: `php artisan migrate:fresh --seed` fails

Check these first:

1. Is MySQL running in XAMPP?
2. Did you create the database `bakery_webapp`?
3. Does `.env` have the same database name?
4. Is `DB_USERNAME` correct?
5. Is `DB_PASSWORD` correct for your XAMPP setup?

### Problem: `php artisan serve` works but browser shows error

Try:

```powershell
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan serve
```

### Problem: "Access denied for user 'root'"

That means MySQL username or password is wrong.

Open `.env` and fix:

- `DB_USERNAME`
- `DB_PASSWORD`

Then run:

```powershell
php artisan config:clear
php artisan migrate:fresh --seed
```

### Problem: port already in use

If Laravel says port `8000` is busy, run:

```powershell
php artisan serve --port=8080
```

Then open:

```text
http://127.0.0.1:8080
```

## Notes about data

- Product stock is reduced automatically when an order is created.
- Expiring a pre-order returns stock to inventory.
- Counter sales are marked as completed immediately.
- Pre-orders start as pending and can move to baking, ready, and completed.

## Files you may need to open often

- `D:\SE\bakery-webapp\.env`
- `D:\SE\bakery-webapp\README.md`
- `D:\SE\bakery-webapp\routes\web.php`

## If you want the next help

If you get stuck on any single step, tell me exactly which step number failed and copy the error message. Then I can help from that exact point instead of guessing.
