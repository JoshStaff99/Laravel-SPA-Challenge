<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        \Illuminate\Http\Middleware\SetCacheHeaders::class, // Caching headers
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, // Post size validation
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\HandleInertiaRequests::class, // Custom Inertia handling
        ],

        'api' => [
            EnsureFrontendRequestsAreStateful::class, // Sanctum middleware for SPA authentication
            'throttle:api', // Rate limit API requests
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
        'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class, // Redirect if authenticated
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class, // Password confirmation
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class, // Validate signed URLs
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class, // Rate limiting
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // Ensure email verification
    ];
}
