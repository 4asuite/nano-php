<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Router for processing and matching HTTP paths.
 */
final class Router
{
    public function __construct(private array $routes) {}

    /**
     * Finds the matching controller and method for the given request.
     *
     * @return array [controllerClass, method, params]
     * @throws HttpException 404 if the path does not exist
     */
    public function match(Request $request): array
    {
        $method = $request->method();
        $path   = $request->path();

        $map = $this->routes[$method] ?? [];

        // Exact match
        if (isset($map[$path])) {
            [$class, $action] = $map[$path];
            return [$class, $action, []];
        }

        // Parameterized routes
        foreach ($map as $route => $handler) {
            if (!str_contains($route, '(:')) {
                continue;
            }

            $paramNames = [];

            $pattern = preg_replace_callback(
                '#\(:([a-z]+):([a-zA-Z_][a-zA-Z0-9_]*)\)#',
                function ($m) use (&$paramNames) {
                    $paramNames[] = $m[2];
                    return match ($m[1]) {
                        'num'  => '([0-9]+)',
                        'any'  => '([^/]+)',
                        default => '([^/]+)',
                    };
                },
                preg_quote($route, '#')
            );

            if (preg_match('#^' . $pattern . '$#', $path, $matches)) {
                array_shift($matches);
                $params = array_combine($paramNames, $matches);
                return [$handler[0], $handler[1], $params];
            }
        }

        throw new HttpException(404, '404 – Page Not Found');
    }
}
