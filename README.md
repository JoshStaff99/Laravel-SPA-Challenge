# Laravel-SPA-Challenge

A single-page application built with Laravel 12, Inertia.js, Vue.js 3, and Tailwind CSS for managing a movie collection. The application demonstrates CRUD operations, session-based authentication, API token authentication via Sanctum, and a fully responsive mobile-first user interface.

## Features

- **Display Movies**: View a list of all movies with details including title, director, release date, duration, and tags
- **Search & Multi-Filter**: Filter movies by title, director, release year, and tags
- **Tag Display**: View tags as visual chips on both movie grid and detail pages
- **CRUD Operations**: Add, edit, and delete movies (requires authentication)
- **Authentication Guards**: Guests are redirected to login; only authenticated users can edit/delete
- **RESTful API**: Full REST API with proper validation and error handling (Sanctum token-based)
- **Session Authentication**: Web routes use Laravel session authentication for Inertia
- **Responsive Design**: Mobile-first Tailwind CSS with burger menu for small screens
- **Single Page Application**: Inertia.js + Vue 3 for seamless page transitions without full page reloads

## Technology Stack

- **Backend**: Laravel 12
- **Frontend**: Vue.js 3 + Inertia.js
- **Styling**: Tailwind CSS 3
- **Database**: MySQL
- **API Authentication**: Laravel Sanctum (token-based)
- **Session Authentication**: Laravel session middleware
- **Build Tool**: Vite
- **Testing**: PHPUnit with RefreshDatabase
- **HTTP Client**: Axios (via Inertia)

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL 8.0+
- Git

## Quick Start

If you want to get the app running quickly:

\\\bash
# Clone and navigate
git clone https://github.com/JoshStaff99/Laravel-SPA-Challenge.git
cd Laravel-SPA-Challenge

# Run the setup command
composer run-script setup

# Start development servers
composer run dev
\\\

This runs all necessary setup steps including composer install, npm install, migrations, and seeding.

## Installation

### 1. Clone the repository
\\\bash
git clone https://github.com/JoshStaff99/Laravel-SPA-Challenge.git
cd Laravel-SPA-Challenge
\\\

### 2. Install PHP dependencies
\\\bash
composer install
\\\

### 3. Install Node dependencies
\\\bash
npm install
\\\

### 4. Environment setup
\\\bash
cp .env.example .env
php artisan key:generate
\\\

### 5. Database setup

Update your \.env\ file with database credentials:

\\\env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_spa_challenge
DB_USERNAME=root
DB_PASSWORD=
\\\

Ensure the database exists before running migrations:

\\\bash
mysql -u root -p -e "CREATE DATABASE laravel_spa_challenge;"
\\\

### 6. Run migrations and seeders
\\\bash
php artisan migrate --seed
\\\

### 7. Build frontend assets
\\\bash
npm run build
\\\

## Usage

### Development Environment

To start the development server with live reload:

\\\bash
# Terminal 1: Start Vite dev server (watches Vue/JS/CSS changes)
npm run dev

# Terminal 2: Start Laravel server
php artisan serve
\\\

The application will be available at \http://localhost:8000\

### Production Build
\\\bash
npm run build
php artisan serve
\\\

## Deployment

To deploy this application to a production server:

1. **Clone repository** on your server
2. **Configure environment**: Copy \.env.example\ to \.env\ and update with production settings
3. **Install dependencies**: \composer install --no-dev\ and \
pm install\
4. **Generate app key**: \php artisan key:generate\
5. **Run migrations**: \php artisan migrate --force\
6. **Seed database** (optional): \php artisan db:seed --force\
7. **Build frontend**: \
pm run build\
8. **Cache config**: \php artisan config:cache && php artisan route:cache\
9. **Set permissions**: Ensure \storage/\ and \bootstrap/cache/\ are writable
10. **Use a web server**: Configure Nginx or Apache to point to the \public/\ directory

### Recommended web server configuration:
- **Nginx** with PHP-FPM
- **Apache** with mod_php or PHP-FPM
- Use a reverse proxy (Nginx) in front for SSL/HTTPS
- Enable CORS if frontend and API are on different domains

## API Documentation

### Authentication Flow

The application supports two authentication methods:

#### Web Routes (Inertia/Session)
- Uses Laravel's session middleware for authenticated routes
- Login/Register pages handle session-based authentication
- Guests are redirected to login page
- Cookies contain session tokens

#### API Routes (Sanctum Token)
1. **Register/Login**: Get an API token via \POST /api/login\
2. **Include token**: Add \Authorization: Bearer {token}\ header to protected requests
3. **Logout**: Call \POST /api/logout\ to invalidate token

### Response Format

**Successful responses (2xx):**
\\\json
{
  "data": {...},
  "meta": {
    "pagination": {...}
  }
}
\\\

**Error responses:**
\\\json
{
  "message": "Error message",
  "errors": {
    "field": ["Error detail"]
  }
}
\\\

### Public API Routes

**POST /api/login** - Login and receive API token
- Request: \{ "email": "user@example.com", "password": "password" }\
- Response: \{ "user": {...}, "token": "..." }\

**GET /api/movies** - Get all movies (paginated)
- Query params: \?search=title&director=name&year=2024&tag=sci-fi&page=1&per_page=15\
- Response: Array of movies with pagination metadata

**GET /api/movies/{id}** - Get a specific movie
- Response: Single movie object with all fields

### Protected API Routes

All protected routes require the \Authorization: Bearer {token}\ header.

**POST /api/movies** - Create a new movie
- Request: \{ "title": "...", "director": "...", "description": "...", "duration": 120, "release_date": "2025-01-01", "tags": "sci-fi,action" }\
- Response: Created movie object (201)

**PUT /api/movies/{id}** - Update a movie (all fields required)
- Request: Same as POST /api/movies
- Response: Updated movie object (200)

**PATCH /api/movies/{id}** - Partially update a movie
- Request: Partial fields \{ "title": "New Title" }\
- Response: Updated movie object (200)

**DELETE /api/movies/{id}** - Delete a movie
- Response: Empty (204)

**POST /api/logout** - Logout and invalidate token
- Response: \{ "message": "Logged out" }\

### Query Parameters

**Movies List Filtering:**
- \search\ - Filter by title or director name (substring match)
- \director\ - Exact director name match
- \year\ - Release year filter
- \	ag\ - Filter by tag (comma-separated tags in database)
- \page\ - Pagination page number (default: 1)
- \per_page\ - Results per page (default: 15)

Example: \GET /api/movies?search=action&director=Nolan&year=2023&tag=sci-fi&page=1\

## Testing

### Default User Credentials (for testing)
After running the migrations and seeding, a default user will be created. You can use the following credentials to log in:

- **Email**: \	est@example.com\
- **Password**: \password\

### Setup Testing Environment

Ensure \.env.testing\ exists with a separate test database:

\\\env
APP_ENV=testing
APP_DEBUG=true
DB_DATABASE=laravel_spa_challenge_testing
\\\

Create the test database:
\\\bash
mysql -u root -p -e "CREATE DATABASE laravel_spa_challenge_testing;"
\\\

### Run Tests

\\\bash
# All tests
php artisan test

# Specific test file
php artisan test tests/Feature/MovieApiSearchTest.php

# With coverage report
php artisan test --coverage

# Watch mode (rerun tests on file changes)
php artisan test --watch
\\\

### Test Coverage

Current test coverage includes:

| Feature | Test File | Status |
|---------|-----------|--------|
| Movie API CRUD | tests/Feature/ApiTest.php |  |
| Movie Search & Filter | tests/Feature/MovieApiSearchTest.php |  |
| Authentication | tests/Feature/Auth/RegistrationTest.php |  |
| User Profile | tests/Feature/ProfileTest.php |  |
| Movie Unit Model | tests/Unit/MovieTest.php |  |

All tests pass with proper isolation using \RefreshDatabase\ trait.

### Writing New Tests

Tests are located in \	ests/Feature/\ and \	ests/Unit/\. Example:

\\\php
#[\PHPUnit\Framework\Attributes\Test]
public function authenticated_user_can_create_movie()
{
    \ = User::factory()->create();
    
    \ = \->actingAs(\)->postJson('/api/movies', [
        'title' => 'Test Movie',
        'director' => 'Test Director',
        'description' => 'Test Description',
        'duration' => 120,
        'release_date' => '2025-01-01',
        'tags' => 'test,movie'
    ]);
    
    \->assertStatus(201);
    \->assertDatabaseHas('movies', ['title' => 'Test Movie']);
}
\\\

## Database Schema

### Movies Table
\\\sql
CREATE TABLE movies (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    director VARCHAR(255),
    description TEXT,
    duration INT,
    release_date DATE,
    tags VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
\\\

**Fields:**
- \id\: Unique movie identifier
- \	itle\: Movie title (required)
- \director\: Director name (optional)
- \description\: Movie synopsis (optional)
- \duration\: Duration in minutes (optional)
- \
elease_date\: Release date in Y-m-d format (optional)
- \	ags\: Comma-separated tags string (optional, displayed as chips in UI)

### Users Table
Standard Laravel users table with email/password authentication for session-based login.

### Personal Access Tokens Table
Stores Laravel Sanctum API tokens for token-based API authentication.

## Project Structure

\\\
Laravel-SPA-Challenge/
 app/
    Http/
       Controllers/
          Api/MovieApiController.php
          Auth/RegisteredUserController.php
          MovieController.php
       Requests/
       Resources/
       Middleware/
       Kernel.php
    Models/
       Movie.php
       User.php
    Providers/
        AppServiceProvider.php
        RouteServiceProvider.php
 bootstrap/
    app.php
    providers.php
 config/
    app.php
    auth.php
    database.php
    sanctum.php
 database/
    factories/
       UserFactory.php
    migrations/
    seeders/
        DatabaseSeeder.php
        MoviesTableSeeder.php
 resources/
    js/
       app.js
       bootstrap.js
       Components/
       Layouts/
          AppLayout.vue
       Pages/
           Movies/
              Index.vue
              Create.vue
              Edit.vue
              Show.vue
           Auth/
               Login.vue
               Register.vue
    css/
       app.css
    views/
        app.blade.php
 routes/
    api.php
    auth.php
    web.php
    console.php
 storage/
    app/
    framework/
    logs/
 tests/
    Feature/
       ApiTest.php
       MovieApiSearchTest.php
       ProfileTest.php
       Auth/RegistrationTest.php
    Unit/
       MovieTest.php
    TestCase.php
 public/
    index.php
    robots.txt
    hot
    build/
 .env.example
 artisan
 composer.json
 package.json
 vite.config.js
 tailwind.config.js
 phpunit.xml
 README.md
\\\

## Configuration

### Environment Variables

Key environment variables in \.env\:

\\\env
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
\\\

### Testing Environment

To run tests, ensure \.env.testing\ is configured with a separate database:

\\\env
APP_ENV=testing
APP_DEBUG=true
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_spa_challenge_testing
DB_USERNAME=root
DB_PASSWORD=
\\\

## Troubleshooting

### Database connection errors
- Verify MySQL is running
- Check \.env\ database credentials
- Ensure the database exists: \CREATE DATABASE laravel_spa_challenge;\

### Node Modules Issues
\\\bash
# Clear the cache
npm cache clean --force

# Reinstall dependencies
rm -rf node_modules && npm install
\\\

### Laravel Cache Issues
\\\bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
\\\

### Vite Hot Module Reload Issues
- Ensure \
pm run dev\ is running in a separate terminal
- Check browser console for connection errors to HMR server
- Verify \APP_URL\ in \.env\ matches your local URL

### Port Already in Use
\\\bash
# If port 8000 is in use, start Laravel on a different port
php artisan serve --port=8001

# If port 5173 (Vite) is in use, Vite will auto-increment to 5174, etc.
\\\

## Development Notes

- **Authentication**: The application uses Laravel session middleware for web routes and Sanctum tokens for API routes
- **Validation**: Server-side validation enforces \date_format:Y-m-d\ for release dates; invalid dates are rejected
- **API Responses**: All API responses follow RESTful conventions with proper status codes (201 created, 204 no content, 422 validation errors)
- **Frontend**: Inertia.js automatically shares server props with Vue components; auth state available via \page.props.auth\
- **Filters**: Movie filtering is available on both API and web routes with identical query parameters
- **Tags**: Tags are stored as comma-separated strings; displayed as visual chips in the UI
- **Responsive Design**: Uses Tailwind CSS breakpoints; mobile burger menu hidden on sm+ screens

## License

MIT License. See LICENSE file for details.

## Support

For issues or questions, please open an issue on the [GitHub repository](https://github.com/JoshStaff99/Laravel-SPA-Challenge).
