<?php
declare(strict_types=1);

namespace App\Core;

final class Csrf
{
    private const KEY = '_csrf';

    public static function token(): string
    {
        Session::start();

        $token = Session::get(self::KEY);
        if (!is_string($token) || $token === '') {
            $token = bin2hex(random_bytes(32));
            Session::set(self::KEY, $token);
        }
        return $token;
    }

    public static function verify(?string $token): void
    {
        Session::start();

        $stored = Session::get(self::KEY);
        if (!is_string($stored) || !is_string($token) || !hash_equals($stored, $token)) {
            throw new HttpException(419, 'Invalid CSRF token');
        }

        $newToken = bin2hex(random_bytes(32));
        Session::set(self::KEY, $newToken);
    }

    public static function input(): string
    {
        $t = self::token();
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars($t, ENT_QUOTES) . '">';
    }
}