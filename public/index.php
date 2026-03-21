<?php
declare(strict_types=1);

/**
 * Application entry point.
 * The only PHP file accessible from the web server.
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../App/bootstrap.php';

$app->run();
