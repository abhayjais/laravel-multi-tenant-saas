# Multi-Tenant SaaS: User with Multiple Companies

This project is a minimal backend for a multi-tenant SaaS application built with Laravel. It demonstrates how a single registered user can create, manage, and switch between multiple companies under their profile. All subsequent data and actions are scoped to the currently active company.

## Setup Instructions

Follow these steps to get the project up and running on your local machine.

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL

### Installation

1.  Clone the repository:
    ```bash
    git clone [https://github.com/YOUR_USERNAME/laravel-multi-tenant-saas.git](https://github.com/YOUR_USERNAME/laravel-multi-tenant-saas.git)
    cd laravel-multi-tenant-saas
    ```

2.  Install PHP and JavaScript dependencies:
    ```bash
    composer install
    npm install
    npm run dev
    ```

3.  Set up your `.env` file by copying the example and updating your database credentials:
    ```bash
    cp .env.example .env
    ```
    _Make sure to set your MySQL credentials in `.env`._

4.  Generate an application key and run the database migrations:
    ```bash
    php artisan key:generate
    php artisan migrate
    ```

5.  Start the development server:
    ```bash
    php artisan serve
    ```

## API Endpoints

The API is built to be consumed by a front-end application. All protected endpoints require a bearer token in the `Authorization` header.

### 1. Authentication
| Endpoint | Method | Description |
|---|---|---|
| `/api/register` | `POST` | Registers a new user. |
| `/api/login` | `POST` | Logs in an existing user and returns a token. |
| `/api/logout` | `POST` | Invalidates the user's current token. |

**Example Request (`/api/register`)**
```json
{
    "name": "John Doe",
    "email": "john.doe@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}