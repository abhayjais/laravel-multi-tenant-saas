# Multi-Tenant SaaS Backend

This project is a minimal backend for a multi-tenant SaaS application built with Laravel. It demonstrates how a single registered user can create, manage, and switch between multiple companies under their profile. All subsequent data and actions are scoped to the currently active company.

## Key Features

-   **User Authentication**: Registration, login, and logout.
-   **Multi-Company Management**: Users can create, list, update, and delete companies they own.
-   **Company Switching**: An endpoint to set the user's active company.
-   **Data Scoping**: All subsequent data access is isolated to the active company.

---

## Setup Instructions

Follow these steps to get the project up and running on your local machine.

1.  **Clone the project and install dependencies.**
    git clone https://github.com/abhayjais/laravel-multi-tenant-saas.git
    cd your-repo
    composer install
    npm install && npm run dev

2.  **Configure the environment.**
    cp .env.example .env
    Update your `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in the `.env` file for a MySQL connection.

3.  **Run migrations and start the server.**
    php artisan key:generate
    php artisan migrate
    php artisan serve

---

## API Endpoints

All endpoints related to companies and data scoping require a valid **Bearer Token** in the `Authorization` header.

### Authentication
-   **`POST /api/register`**: Register a new user.
-   **`POST /api/login`**: Log in and get a token.
-   **`POST /api/logout`**: Log out.

### Company Management
-   **`GET /api/companies`**: List all companies for the logged-in user.
-   **`POST /api/companies`**: Create a new company.
-   **`PUT /api/companies/{id}`**: Update an existing company.
-   **`DELETE /api/companies/{id}`**: Delete a company.

### Company Switching
-   **`POST /api/company/switch`**: Set the active company for the user.

---

## Multi-Tenancy Logic

The multi-tenant logic is simple and effective. Each user has a **`current_company_id`** column on their record, which tracks their active company.

To enforce data isolation, a custom middleware, `EnsureCompanyIsSet`, is used. This middleware checks if a user has an active company before allowing access to any scoped resources. All data operations (e.g., creating a project or invoice) will automatically use this `current_company_id`, ensuring a user can only access data belonging to their currently selected company.

---

## Testing with Postman

For easy testing of all API endpoints, a Postman collection file named **`Assignment.postman_collection.json`** has been included in the project root. This file contains all the necessary requests, including examples for registration, login, company management, and switching companies.