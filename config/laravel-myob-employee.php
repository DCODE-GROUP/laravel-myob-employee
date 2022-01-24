<?php

return [

    /*
     |
     | Specify the model which is being used to link Xero employees to the app.
     | Generally this will be the User model
     |
     */
    'employee_model' => env('LARAVEL_MYOB_EMPLOYEE_MODEL', App\Models\User::class),

    /*
    |--------------------------------------------------------------------------
    | Laravel MYOB Employee Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Laravel MYOB Employee will be accessible from. Feel free
    | to change this path to anything you like.
    |
    */

    'path' => env('LARAVEL_MYOB_EMPLOYEE_PATH', 'myob-employee'),

    /*
    |--------------------------------------------------------------------------
    | Laravel MYOB Employee Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will get attached onto each Laravel MYOB Employee route, giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with this list.
    |
    */

    'middleware' => [
        'web',
        'auth',
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel MYOB Payroll AU Job Queue
    |--------------------------------------------------------------------------
    |
    | This will allow you to configure queue to use for background jobs
    |
    */

    'queue' => env('LARAVEL_MYOB_EMPLOYEE_QUEUE', 'default'),

];