# 🍞 Bakery Inventory & Ordering Web App

A premium, modern Laravel & Vite web application designed for bakeries to manage their profile, products, live inventory, and orders with automated discount rules and a multi-method customer checkout system.

---


## 🐳 Option A: Setup using Docker (Recommended & Zero Configuration)

This is the fastest and cleanest way to run the web application. You do **not** need to install PHP, Composer, Node, or XAMPP on your computer.

### Prerequisites:
1. Make sure **Docker Desktop** is installed and running on your computer. Download: [https://www.docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop)

### Running the App:
1. Open your terminal (PowerShell, Command Prompt, or Git Bash) inside the project folder.
2. Build and start the entire stack:
   ```bash
   docker compose up --build
   ```
3. That's it! Docker will automatically:
   *   Build the PHP + Apache image with all necessary packages.
   *   Compile your frontend CSS & JS assets via Vite.
   *   Wait for the MySQL database to become healthy.
   *   Run all migrations (`migrate`) and populate the database with demo data (`db:seed`).
   *   Create the public storage symlink (`storage:link`).

### URLs & Credentials (Docker):
*   🍞 **Bakery App**: [http://localhost:8088](http://localhost:8088)
*   🗄️ **phpMyAdmin (DB Browser)**: [http://localhost:8081](http://localhost:8081)
*   🔑 **Demo Owner Login**:
    *   **Email:** `owner@bakery.test`
    *   **Password:** `password`

### How to Stop Docker:
*   To stop in the terminal: Press **`Ctrl` + `C`**
*   To stop and clear cache/volumes:
    ```bash
    docker compose down -v
    ```

---

## 💻 Option B: Classic Local Setup (Without Docker)

If you prefer to run the application using XAMPP (Apache + MySQL) and local PHP/Node:

### Prerequisites:
1. **XAMPP** installed (Apache & MySQL active).
2. **PHP 8.2+** installed on your system path.
3. **Composer** installed.
4. **Node.js (v18+) & npm** installed.

### Setup Steps:
1. **Clone & Open Project Folder**:
   ```powershell
   cd C:\Users\Wilson Tjokro\Downloads\bakery-webapp
   ```
2. **Install PHP & Node Packages**:
   ```powershell
   composer install
   npm install
   ```
3. **Configure Environment File**:
   *   Duplicate `.env.example` and rename it to `.env`
   *   Open `.env` and verify your local MySQL credentials:
       ```env
       DB_CONNECTION=mysql
       DB_HOST=127.0.0.1
       DB_PORT=3306
       DB_DATABASE=bakery_webapp
       DB_USERNAME=root
       DB_PASSWORD=
       ```
4. **Create Empty Database**:
   *   Open XAMPP Control Panel and start **Apache** and **MySQL**.
   *   Go to `http://localhost/phpmyadmin` and create a new empty database named `bakery_webapp` (Collation: `utf8mb4_unicode_ci`).
5. **Generate App Security Key**:
   ```powershell
   php artisan key:generate
   ```
6. **Migrate & Seed Database**:
   ```powershell
   php artisan migrate:fresh --seed
   ```
7. **Link Storage (for product images)**:
   ```powershell
   php artisan storage:link
   ```
8. **Compile Frontend Assets**:
   ```powershell
   npm run build
   ```
9. **Start Server**:
   ```powershell
   php artisan serve
   ```
   Open **[http://127.0.0.1:8000](http://127.0.0.1:8000)** in your browser and log in using:
   *   **Email:** `owner@bakery.test`
   *   **Password:** `password`

---


## 🛠️ Troubleshooting

### 1. Stock / Product images are missing:
Make sure to create the storage link:
```powershell
php artisan storage:link
```
If using Docker, this is done automatically! The seed image copies are preserved and loaded on your first spin.

### 2. "Access denied for user 'root'" (Local Setup):
Double-check your MySQL configuration in `.env`. If you have a custom MySQL password set up in XAMPP, you must define it in `.env` as:
```env
DB_PASSWORD=your_mysql_password
```
Followed by clearing cache and running migrations:
```powershell
php artisan config:clear
php artisan migrate:fresh --seed
```

### 3. Port conflict with XAMPP:
If you are running the Docker environment and XAMPP is already active on your machine, MySQL (port 3306) and Apache (port 80) might clash. Stop Apache and MySQL in XAMPP first before starting `docker compose up --build`. (Our docker setup is preconfigured to use ports `8088` and `3307` to minimize conflict, but stopping XAMPP remains best practice).
