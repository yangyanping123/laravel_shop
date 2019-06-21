<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', ''),
        'host'           => env('DB_HOST', '192.168.0.138'),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE', 'yhistory'),
        'username'       => env('DB_USERNAME', 'scott'),
        'password'       => env('DB_PASSWORD', '123456'),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', 'cmf_'),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];
