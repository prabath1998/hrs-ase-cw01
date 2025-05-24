# Web-Based Hotel Reservation System (Laravel)

## 1. Overview

This project is a web-based Hotel Reservation System developed for an individual hotel chain. It aims to manage room bookings, customer information, check-in/check-out processes, billing, and report generation. The system caters to various users including Customers, Travel Companies, Reservation Clerks, Managers, and System Administrators.

This system is built using the Laravel PHP framework.

## 2. Features

The system includes the following core functionalities:

* **User Roles & Permissions:**
  * **Customer:** Account creation, login, make/view/update/cancel reservations, choose extra services, book residential suites, view/download bills.
  * **Travel Company:** Registration, login, block book rooms at discounted rates, pre-payment, track bookings, view/download invoices.
  * **Reservation Clerk (Admin):** Manually handle reservations, check-ins/check-outs, assign rooms, generate bills, add service charges, update pricing.
  * **Manager (Admin):** View occupancy reports, revenue/financial reports, analyze future bookings.
  * **System Admin (Admin):** Manage travel companies, manage admin users and permissions, configure system settings (taxes, discounts).
  * **System (Automated):** Display dynamic pricing, auto-cancel unpaid reservations, auto-charge no-shows, generate daily reports, charge for late check-outs.
* **Room & Suite Management:** Define room types (including weekly/monthly rates for suites) and manage individual room inventory.
* **Reservation Management:** Create, modify, and cancel reservations with options for credit card guarantees.
* **Optional Services:** Allow customers to add extra services to their bookings.
* **Billing & Payments:** Generate itemized bills, process payments (mocked), and handle invoices.
* **Reporting:** Generate various reports for occupancy, revenue, and financial analysis.
* **Automated Tasks:** Nightly processes for cancellations and no-show billing.

## 3. Technologies Used

* **Backend:** PHP, Laravel Framework
* **Frontend:** Blade Templating, HTML, Tailwind CSS, JavaScript
* **Database:** MySQL
* **Key Laravel Packages (Recommended):**
  * `spatie/laravel-permission` (for roles and permissions)
  * Laravel UI Auth (for authentication scaffolding)

## 4. System Requirements (for Development)

* PHP >= 8.1
* Composer
* Node.js >= 22
* A web server (Nginx) or use `php artisan serve`
* A database server (MySQL)

## 5. Project Setup Instructions

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/prabath1998/hrs-ase-cw01.git
    cd hrs-ase-cw01
    ```

2. **Environment Configuration:**
    * Copy the `.env.example` file to `.env`:

        ```bash
        cp .env.example .env
        ```

    * Generate an application key:

        ```bash
        php artisan key:generate
        ```

    * Configure your database connection details in the `.env` file (DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).

3. **Install PHP Dependencies:**

    ```bash
    composer install
    ```

4. **Install NPM Dependencies:**

    ```bash
    npm install
    npm run dev
    ```

5. **Database Migration & Seeding:**
    * Ensure your database is created.
    * Run migrations to create the database schema:

        ```bash
        php artisan migrate
        ```

    * Run seeders to populate the database with initial data (roles, permissions, admin users, sample room types, etc.):

        ```bash
        php artisan db:seed
        ```

6. **Set Up Task Scheduling (for automated 7 PM tasks):**
    * Add the following Cron entry to your server (or use `php artisan schedule:work` during development):

        ```cron
        * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
        ```

7. **Serve the Application (for local development):**

    ```bash
    php artisan serve
    ```

    The application will typically be available at `http://127.0.0.1:8000`.

## 6. Default Admin Credentials (from Seeders)

* **System Admin:**
  * Email: `admin@hotel.com`
  * Password: `password`
* **Manager:**
  * Email: `manager@hotel.com`
  * Password: `password`
* **Reservation Clerk:**
  * Email: `clerk@hotel.com`
  * Password: `password`
* **Customer:**
  * Email: `customer@example.com`
  * Password: `password`

## 7. User Roles & Permissions Overview

* **System Admin:** Full control over the system, including user management, role/permission assignment, travel company management, and system configurations.
* **Manager:** Access to reports, financial data, and can oversee operations. May have some pricing configuration rights.
* **Reservation Clerk:** Handles day-to-day operations like reservations, check-ins/outs, billing, and customer/room management.
* **Travel Company:** Can make block bookings, view their specific bookings and invoices.
* **Customer:** Can make individual reservations, manage their bookings, and view their bills.

*(Refer to the `RolePermissionSeeder.php` for detailed permission assignments).*

## 8. License

This project is released under the [MIT License](LICENSE).
