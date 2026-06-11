# Bakery Inventory and Ordering Web Application

This project is a modern Laravel and Vite web application designed for bakeries. It provides functionality for managing bakery profiles, products, real-time inventory, and orders. It includes features for automated discount rules and a multi-method customer checkout system.

---

## Technical Stack

- Backend: Laravel (PHP 8.2)
- Frontend: Vite, Tailwind CSS, Blade Templates
- Database: MySQL 8.0
- Infrastructure: Docker and Docker Compose

---

## Setup Options

### Option A: Setup using Docker (Recommended)

Docker is the preferred method for running this application as it ensures a consistent environment and requires no local installation of PHP, Node.js, or MySQL.

#### Prerequisites
- Docker Desktop installed and running.

#### Installation Steps
1. Open a terminal in the project root directory.
2. Build and start the containers:
   ```bash
   docker compose up --build
   ```
3. The initialization process will automatically:
   - Build the PHP-Apache environment.
   - Compile frontend assets via Vite.
   - Configure the MySQL database.
   - Run database migrations and seeders.
   - Establish the necessary storage symlinks.

#### Access Information
- Web Application: http://localhost:8088
- phpMyAdmin: http://localhost:8081
- Default Admin Credentials:
  - Email: owner@bakery.test
  - Password: password

#### Stopping the Application
- To stop the containers: Press Ctrl + C in the terminal.
- To stop and remove volumes (resetting the database):
  ```bash
  docker compose down -v
  ```

---

### Option B: Local Setup (Manual)

Use this method if you prefer to run the application using a local development environment such as XAMPP.

#### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js (v18 or higher) and npm
- MySQL Server

#### Installation Steps
1. Install PHP and Node dependencies:
   ```bash
   composer install
   npm install
   ```
2. Configure Environment:
   - Copy `.env.example` to `.env`.
   - Update the `DB_*` variables in `.env` to match your local database configuration.
3. Database Setup:
   - Create an empty database named `bakery_webapp`.
   - Run migrations and seed data:
     ```bash
     php artisan key:generate
     php artisan migrate:fresh --seed
     ```
4. Asset Compilation and Storage:
   - Create the storage symlink:
     ```bash
     php artisan storage:link
     ```
   - Build the frontend assets:
     ```bash
     npm run build
     ```
5. Run the Application:
   ```bash
   php artisan serve
   ```
   Access the application at http://127.0.0.1:8000.

---

## Troubleshooting

### Product Images Not Displaying
Ensure the storage symlink has been created. For local setups, run:
```bash
php artisan storage:link
```
In Docker environments, this is handled automatically during the build process.

### Database Connection Issues
Verify the credentials in the `.env` file. If configuration changes are made, clear the application cache:
```bash
php artisan config:clear
```

### Port Conflicts
The Docker environment is configured to use port 8088 for the web server and 3307 for MySQL. If these ports are occupied, ensure any local services like XAMPP or other Docker containers are stopped.
