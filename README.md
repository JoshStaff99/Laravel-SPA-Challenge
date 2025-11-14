# Laravel-SPA-Challenge

A single-page application built with Laravel 12, Inertia.js, Vue.js, and Tailwind CSS for managing a movie collection. The application demonstrates CRUD operations, authentication via API tokens, and a responsive user interface.

## Features

- **Display Movies**: View a list of all movies with details including title, director, release date, and duration
- **Search & Filter**: Filter movies by title, director, or tags
- **CRUD Operations**: Add, edit, and delete movies (requires authentication)
- **RESTful API**: Full REST API with proper validation and error handling
- **Authentication**: Sanctum API token-based authentication
- **Responsive Design**: Tailwind CSS for responsive, mobile-friendly UI
- **Single Page Application**: Inertia.js + Vue.js for seamless page transitions

## Technology Stack

- **Backend**: Laravel 12
- **Frontend**: Vue.js 3 + Inertia.js
- **Styling**: Tailwind CSS
- **Database**: MySQL
- **API Authentication**: Laravel Sanctum
- **Build Tool**: Vite

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL 8.0+
- Git

## Quick Start

If you want to get the app running quickly:

```bash
# Clone and navigate
git clone https://github.com/JoshStaff99/Laravel-SPA-Challenge.git
cd Laravel-SPA-Challenge

# Run the setup command
composer run-script setup

# Start development servers
composer run dev
```

This runs all necessary setup steps including composer install, npm install, migrations, and seeding.

## Installation

### 1. Clone the repository
```bash
git clone https://github.com/JoshStaff99/Laravel-SPA-Challenge.git
cd Laravel-SPA-Challenge
```

### 2. Install PHP dependencies
...bash
composer install
3. Install Node dependencies
...bash
npm install
4. Environment setup
...bash
cp .env.example .env
php artisan key:generate
5. Database setup
Update your .env file with database credentials:

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_spa_challenge
DB_USERNAME=root
DB_PASSWORD=

Ensure the database exists before running migrations:

CREATE DATABASE laravel_spa_challenge;

6. Run migrations and seeders
...bash
php artisan migrate --seed

7. Build frontend assets
...bash
npm run build
Usage
Development Environment
To start the development server with live reload:

...bash
npm run dev
In a separate terminal, start the Laravel server:

...bash
php artisan serve
The application will be available at http://localhost:8000

Production Build
```bash
npm run build
php artisan serve
```

## Deployment

To deploy this application to a production server:

1. **Clone repository** on your server
2. **Configure environment**: Copy `.env.example` to `.env` and update with production settings
3. **Install dependencies**: `composer install --no-dev` and `npm install`
4. **Generate app key**: `php artisan key:generate`
5. **Run migrations**: `php artisan migrate --force`
6. **Seed database** (optional): `php artisan db:seed --force`
7. **Build frontend**: `npm run build`
8. **Cache config**: `php artisan config:cache && php artisan route:cache`
9. **Set permissions**: Ensure `storage/` and `bootstrap/cache/` are writable
10. **Use a web server**: Configure Nginx or Apache to point to the `public/` directory

Recommended web server configuration:
- **Nginx** with PHP-FPM
- **Apache** with mod_php or PHP-FPM
- Use a reverse proxy (Nginx) in front for SSL/HTTPS
- Enable CORS if frontend and API are on different domains

## API

### Authentication Flow

1. **Register/Login**: Get an API token via POST `/api/login`
2. **Include token**: Add `Authorization: Bearer {token}` header to protected requests
3. **Logout**: Call POST `/api/logout` to invalidate token

### Response Format

Successful responses (2xx):
```json
{
  "data": {...},
  "meta": {
    "pagination": {...}
  }
}
```

Error responses:
```json
{
  "message": "Error message",
  "errors": {
    "field": ["Error detail"]
  }
}
```

## API
Public Routes
POST /api/login - Login and receive API token

Request body: { "email": "user@example.com", "password": "password" }

Response: { "user": {...}, "token": "..." }

GET /api/movies - Get all movies (paginated)

Query params: ?search=title&page=1&per_page=15

Response: Array of movies with pagination

GET /api/movies/{id} - Get a specific movie

Protected Routes (Requires Authentication)
Add Authorization: Bearer {token} header to all protected routes that require authentication.

POST /api/movies - Create a new movie

Request body: { "title": "...", "director": "...", "description": "...", "duration": 120, "release_date": "2025-01-01", "tags": "..." }

PUT /api/movies/{id} - Update a movie (all fields required)

PATCH /api/movies/{id} - Partially update a movie

DELETE /api/movies/{id} - Delete a movie

POST /api/logout - Logout and invalidate token

## Testing

### Default User Credentials (for testing)
After running the migrations and seeding, a default user will be created. You can use the following credentials to log in:

- **Email**: `test@example.com`
- **Password**: `password`

### Setup Testing Environment

Ensure `.env.testing` exists with a separate test database:

```env
APP_ENV=testing
APP_DEBUG=true
DB_DATABASE=laravel_spa_challenge_testing
```

Create the test database:
```bash
CREATE DATABASE laravel_spa_challenge_testing;
```

### Run Tests

```bash
# All tests
php artisan test

# Specific test file
php artisan test tests/Feature/ApiTest.php

# With coverage report
php artisan test --coverage

# Watch mode (rerun tests on file changes)
php artisan test --watch
```

### Test Coverage

Current test coverage includes:

| Feature | Test | Status |
|---------|------|--------|
| User Login | `user_can_login_and_receive_token` |
| Protected Routes | `user_cannot_access_protected_routes_without_token` |
| CRUD Operations | `authenticated_user_can_crud_movies` |
| Logout | `user_can_logout` |

All 32+ assertions pass ensuring API reliability.

### Writing New Tests

Tests are located in `tests/Feature/`. Example:

```php
#[\PHPUnit\Framework\Attributes\Test]
public function authenticated_user_can_create_movie()
{
    $token = $this->user->createToken('TestApp')->plainTextToken;
    $response = $this->postJson('/api/movies', [
        'title' => 'Test Movie',
        'director' => 'Test Director',
    ], ['Authorization' => 'Bearer ' . $token]);
    
    $response->assertStatus(201);
}
```

Run all tests
Run specific test file
...bash
php artisan test tests/Feature/ApiTest.php
Available Tests
User Authentication: Login, logout, and token generation

Protected Routes: Authorization checks on protected endpoints

CRUD Operations: Create, read, update, delete movies

Validation: Request validation and error handling

Movie Operations: Search, filter, and list operations

Database Schema
Movies Table
sql
CREATE TABLE movies (
    id BIGINT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    director VARCHAR(255) NULLABLE,
    description TEXT NULLABLE,
    duration INT NULLABLE,
    release_date DATE NULLABLE,
    tags VARCHAR(255) NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
Users Table
Standard Laravel users table with email/password authentication

Personal Access Tokens Table
Stores Sanctum API tokens for authentication

Project Structure
pgsql
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   └── MovieApiController.php
│   │   │   ├── Auth/
│   │   │   │   └── AuthController.php
│   │   │   └── ProfileController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── Movie.php
│   │   └── User.php
│   └── Providers/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── js/
│   │   ├── Pages/
│   │   │   ├── Movies/
│   │   │   │   ├── Index.vue
│   │   │   │   ├── Create.vue
│   │   │   │   └── Edit.vue
│   │   │   └── Auth/
│   │   └── app.js
│   ├── css/
│   │   └── app.css
│   └── views/
│       └── app.blade.php
├── routes/
│   ├── api.php
│   ├── web.php
│   └── auth.php
├── tests/
│   └── Feature/
│       └── ApiTest.php
└── public/
Configuration
Environment Variables
Key environment variables in .env:

env
APP_NAME=Laravel-SPA-Challenge
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:...
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_spa_challenge
DB_USERNAME=root
DB_PASSWORD=

SANCTUM_STATEFUL_DOMAINS=localhost:8000
SESSION_DOMAIN=localhost
Testing Environment
To run the tests, ensure that your .env.testing file is set up for testing. This is important to avoid overwriting your production data. You can create a .env.testing file with the following content (use a separate database for testing):

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_spa_challenge_testing
DB_USERNAME=root
DB_PASSWORD=
Troubleshooting
Database connection errors
Verify MySQL is running.

Check .env database credentials.

Ensure the database exists:

...bash
CREATE DATABASE laravel_spa_challenge;
Node Modules Issues
Clear the cache:

...bash
npm cache clean --force
Reinstall dependencies:

...bash
rm -rf node_modules && npm install
Laravel Cache Issues
...bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
Development Notes
The API uses token-based authentication with Laravel Sanctum

All API responses follow RESTful conventions

Validation errors return 422 with error details

The frontend uses Inertia.js for seamless SPA experience

Tailwind CSS is configured for responsive design

License
MIT License. See LICENSE file for details.

Support:
For issues or questions, please open an issue on the GitHub repository.