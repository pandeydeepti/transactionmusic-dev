<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'paypal' => [
        'client_id' => 'AZI8AivWZSccbXBmJwdeV2tXQQdAAyFxt4WstjQpdoVbNnPItNOme0B_kCM14_KUfmuzQL-SFQF7GU85',
        'secret' => 'EA922kt5j2K9rWMK_IRWngC3sQK5OohkrTBrHHTM1wFn7vIwUBkOCyYeP3aXkw3edsTGjpQo8CJJUjXn'
    ],

];
