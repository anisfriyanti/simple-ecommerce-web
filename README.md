# Simple Ecommerce Web

Modern ecommerce web built with Laravel 13, PostgreSQL, Docker, and Tailwind CSS.

## Features

- Authentication
- Product Catalog
- Cart System
- Checkout System
- Order History
- Payment Upload
- Admin Dashboard
- Payment Verification

## Tech Stack

- Laravel 13
- PostgreSQL
- Docker
- Tailwind CSS
- Blade

## Installation

```bash
docker compose up -d
docker compose exec app composer install
docker compose exec app npm install
docker compose exec app php artisan migrate