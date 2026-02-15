# Aplikasi Kasir Watchout & Triset

## Overview

**Aplikasi Kasir Watchout & Triset** is a comprehensive web-based Point of Sale (POS) and Inventory Management system integrated with an Online Store. It is designed to streamline retail operations by managing sales, stock, and employees while providing a seamless online shopping experience for customers.

## Features

- **Point of Sale (POS)**: Efficient interface for processing in-store transactions.
- **Inventory Management**:
  - Real-time stock tracking.
  - Product management (Clothes, Categories, Brands/Merks).
  - Stock checking tools.
- **Online Store**:
  - Customer-facing product catalog.
  - Integrated shopping cart and checkout.
  - Customer account management.
- **Order Management**: Track and manage sales and transaction history.
- **User Management**:
  - Role-based access for Admins, Staff (Pegawai), and Customers.
  - Secure authentication (Login, Register, OTP Verification).
- **Promotions**: Manage discounts and vouchers (including birthday vouchers).
- **Reporting**: Generate sales and transaction reports.
- **Payment Integration**: Midtrans support for online payments.

## Tech Stack

- **Backend**: Native PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript (Bootstrap 5, Iconly)
- **Dependencies**: Composer (for Midtrans PHP SDK)

## Prerequisites

Ensure you have the following installed on your local machine:
- [PHP](https://www.php.net/) (version 7.4 or higher recommended)
- [MySQL](https://www.mysql.com/)
- [Composer](https://getcomposer.org/)

## Installation

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/yafizh/aplikasi-kasir-watchout-triset.git
    cd aplikasi-kasir-watchout-triset
    ```

2.  **Install Dependencies**
    Run the following command to install the required PHP packages:
    ```bash
    composer install
    ```

3.  **Database Setup**
    - Create a new MySQL database named `kasir`.
    - Import the provided SQL files located in `app/database/`:
        1.  Import `app/database/database.sql` (Schema).
        2.  Import `app/database/seeder.sql` (Initial Data).

4.  **Configuration**
    - The database connection is configured in `app/database/koneksi.php`.
    - Default credentials are set to:
        - Host: `localhost`
        - User: `root`
        - Password: `` (empty)
        - Database: `kasir`
    - If your local database configuration differs, update `app/database/koneksi.php` accordingly.

## Usage

1.  **Start the Server**
    You can use a local server environment like XAMPP/WAMP or the PHP built-in server:
    ```bash
    php -S localhost:8000
    ```

2.  **Access the Application**
    - **Online Store (Customer View)**: Open your browser and navigate to `http://localhost:8000`. This will redirect you to the main store page.
    - **Admin/Staff Login**: Access the login page at `http://localhost:8000/app/halaman/auth/login.php`.

## Directory Structure

- `app/`: Main application code.
    - `ajax/`: AJAX handlers and API-like endpoints.
    - `assets/`: Static assets (CSS, JS, Images).
    - `database/`: Database connection and SQL files.
    - `halaman/`: View files and page logic (organized by feature).
    - `helper/`: Utility functions.
    - `route/`: Routing logic.
