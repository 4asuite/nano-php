<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Base class for all controllers in the application.
 *
 * Provides common functionality: view rendering, redirects,
 * JSON responses and access to request/response objects.
 */
abstract class Controller
{
    public function __construct(
        protected Request $request,
        protected Response $response
    ) {}

    /**
     * Renders a view file through a layout and returns a Response.
     *
     * @param string $view   Path to the view relative to app/views/ (e.g. 'home/index')
     * @param array  $data   Variables available in the view
     * @param string $layout Layout name (default 'main')
     */
    protected function view(string $view, array $data = [], string $layout = 'main'): Response
    {
        $html = (new View())->render($view, $data, $layout);
        return $this->response->html($html);
    }

    /**
     * Returns a JSON response.
     */
    protected function json(mixed $data, int $status = 200): Response
    {
        return $this->response->json($data, $status);
    }

    /**
     * Redirects to the given URL.
     */
    protected function redirect(string $url, int $code = 302): Response
    {
        return $this->response->redirect($url, $code);
    }
}
