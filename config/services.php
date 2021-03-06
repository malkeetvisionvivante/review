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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '750065907727-s2go3rslbu0th8jhhesc8mq6s8gqeivf.apps.googleusercontent.com',
        'client_secret' => 'xJ-WYJ7JQucbblsPW5WuEqVJ',
        'redirect' => 'http://server.visionvivante.com:8080/review_system/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => '261562538427785',
        'client_secret' => '1bed053d76579aab94e999e13983dbe1',
        'redirect' => 'http://server.visionvivante.com:8080/review_system/auth/facebook/callback',
    ],

    'linkedin' => [
        'client_id' => '78mf8uu8gqcyot',
        'client_secret' => 'hZRyZHPkvm648kG9',
        'redirect' => 'http://server.visionvivante.com:8080/review_system/auth/linkedin/callback',
    ],
];
