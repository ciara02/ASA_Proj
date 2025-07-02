<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('OC_TNS', ''),
        'host'           => env('OC_HOST', ''),
        'port'           => env('OC_PORT', '1521'),
        'database'       => env('OC_DATABASE', ''),
        'username'       => env('OC_USERNAME', ''),
        'password'       => env('OC_PASSWORD', ''),
        'charset'        => env('OC_CHARSET', 'AL32UTF8'),
        'prefix'         => env('OC_PREFIX', ''),
        'prefix_schema'  => env('OC_SCHEMA_PREFIX', ''),
        'edition'        => env('OC_EDITION', 'ora$base'),
        'server_version' => env('OC_SERVER_VERSION', '11g'),
    ],
];

