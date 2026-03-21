<?php
declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

use     App\Core\App;
use App\Core\Router;
use App\Core\Response;
use App\Core\Session;

// Load .env
require_once __DIR__ . '/Core/EnvLoader.php';
loadEnvAndDefineConstants(dirname(__DIR__));

// Configure error display based on APP_ENV
if (defined('APP_ENV') && APP_ENV === 'production') {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
} else {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

// Start session
Session::start();

// Load route configuration
$routes = require __DIR__ . '/Config/routes.php';

// Create application instance
$app = new App(
    new Router($routes),
    new Response()
);
