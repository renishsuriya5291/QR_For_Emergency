<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'firebase' => [
        'api_key' => 'AIzaSyBlxH5j1kaG7HkszrXb0CuZz964a9_LVdo',
        'auth_domain' => 'angular-app-c73ca.firebaseapp.com',
        'database_url' => 'https://angular-app-c73ca-default-rtdb.firebaseio.com/',
        'project_id' => 'angular-app-c73ca',
        'storage_bucket' => 'angular-app-c73ca.appspot.com',
        'messaging_sender_id' => '2800705935',
        'app_id' => '1:2800705935:web:ae21a76541c01fe46aebfa',
        'measurement_id' => 'G-4HWE5F7LED'
    ],
    

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => 'http://127.0.0.1:8000/auth/google/call-back',
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => 'http://127.0.0.1:8000/auth/facebook/call-back',
    ],
    
    

];
