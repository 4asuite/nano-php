<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

abstract class Model
{
    protected static ?PDO $db = null;

    public function __construct()
    {
        if (self::$db === null) {
            // Uses constants already defined by EnvLoader in bootstrap
            self::$db = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
    }

    protected function db(): PDO
    {
        return self::$db;
    }
}