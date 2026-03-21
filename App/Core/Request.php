<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Class representing an HTTP request.
 *
 * Provides methods for retrieving information about the current HTTP request,
 * such as the HTTP method and path.
 */
final class Request
{
    /**
     * Returns the HTTP method of the current request.
     *
     * @return string HTTP method (e.g. GET, POST, PUT, DELETE)
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    /**
     * Returns the path from the URL without query parameters.
     *
     * Strips the query string from the URI and trailing slash, keeping
     * the root path as '/'.
     *
     * @return string Normalized request path
     */
    public function path(): string
    {
        $uri = explode('?', $_SERVER['REQUEST_URI'] ?? '/', 2)[0];
        return rtrim($uri, '/') ?: '/';
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}
