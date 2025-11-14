<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful; // Sanctum middleware for SPA authentication

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * This value is used by the `Illuminate\Http\Request` during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        \Illuminate\Http\Middleware\SetCacheHeaders::class,  // Caching headers
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, // Post size validation
    ];

    /**
     * The application's route middleware groups.
     *
     * These middleware are assigned to groups of routes.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\HandleInertiaRequests::class,  // Custom Inertia handling
        ],

        'api' => [
            EnsureFrontendRequestsAreStateful::class, // Sanctum SPA authentication
            'throttle:api',  // Rate limit API requests
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Route model binding
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware can be assigned to specific routes or controllers.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class, // Built-in authentication middleware
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class, // Basic authentication
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class, // Route model binding
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class, // Cache headers
        'can' => \Illuminate\Auth\Middleware\Authorize::class, // Authorization checks
        'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class, // Use built-in RedirectIfAuthenticated middleware
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class, // Password confirmation
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class, // Validate signed URLs
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class, // Rate limiting
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // Ensure email verification
        'auth.sanctum' => \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // Sanctum middleware
    ];
}