<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Main application class of the framework.
 *
 * Manages the application lifecycle and coordinates HTTP request processing
 * using the router, controllers and response objects.
 */
final class App
{
    public function __construct(
        private Router $router,
        private Response $response
    ) {}

    public function run(): void
    {
        try {
            $request = new Request();

            [$controllerClass, $method, $params] = $this->router->match($request);

            $controller = new $controllerClass($request, $this->response);

            $response = $controller->$method(...array_values($params));

            if (!$response instanceof Response) {
                throw new \RuntimeException('Controller must return a Response instance.');
            }

            $response->send();

        } catch (HttpException $e) {
            $this->response
                ->status($e->statusCode)
                ->body('<h1>' . htmlspecialchars($e->getMessage()) . '</h1>')
                ->send();
        }
    }
}
