<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. You may change these values
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'admin', // Set default guard to 'admin'
        'passwords' => 'admins', // Set default password broker to 'admins'
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'admins', // Change 'web' guard to use 'admins' provider
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'sanctum' => [ // Keep sanctum guard for API authentication
            'driver' => 'sanctum',
            'provider' => 'admins', // Sanctum also uses 'admins' provider
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved out of your database or other storage
    | system used by the application.
    |
    */

    'providers' => [
        // Remove or comment out the 'users' provider block completely
        // 'users' => [
        //     'driver' => 'eloquent',
        //     'model' => env('AUTH_MODEL', App\Models\User::class),
        // ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | These configuration options specify the behavior of Laravel's password
    | reset functionality.
    |
    */

    'passwords' => [
        'admins' => [ // Change password broker to 'admins'
            'provider' => 'admins',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | window expires.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];