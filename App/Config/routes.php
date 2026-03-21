<?php
declare(strict_types=1);

/**
 * Configuration file for defining application routes.
 *
 * Structure:
 * [
 *     'HTTP_METHOD' => [
 *         '/path' => [ControllerClass::class, 'method'],
 *     ]
 * ]
 */

return [
    'GET' => [
        // Add GET routes here, for example:
        '/' => [App\Controllers\NanofwController::class, 'index'],
    ],
    'POST' => [

    ],
];
