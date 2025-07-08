<?php

require_once realpath(__DIR__ . '/bootstrap.php');

return [
    'db' => [
        'host' => $_ENV['DB_HOST'],
        'dbname' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'pass' => $_ENV['DB_PASSWORD'],
        'charset' => 'utf8mb4',
    ]
];
