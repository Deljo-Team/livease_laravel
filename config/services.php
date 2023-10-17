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
    'otp'=>[
        'interface'=>env('OTP_INTERFACE','email'), //phone or email
        'length'=>env('OTP_LENGTH',6),
        'token_length'=>env('OTP_TOKEN_LENGTH',10),
        'expiry'=>env('OTP_EXPIRY',5),
        'custom_number'=>env('OTP_CUSTOM_NUMBER'),
        'attempts'=>env('OTP_ATTEMPTS',3),
        'debug'=>env('OTP_DEBUG',false),

    ],
    'file'=>[
        'interface'=>env('FILE_INTERFACE','file'), //file or s3
        'path'=>env('FILE_PATH','public'),
        'disk'=>env('FILE_DISK','local'),
    ],
    'reward'=>[
        'rewardPointWorth'=>env('REWARD_POINT_WORTH',10),
    ]

];
