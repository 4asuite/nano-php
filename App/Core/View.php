<?php
declare(strict_types=1);

namespace App\Core;

final class View
{
    public function render(string $view, array $data = [], string $layout = 'main'): string
    {
        $viewsDir = realpath(dirname(__DIR__) . '/views');

        $viewFile = realpath($viewsDir . '/' . ltrim($view, '/') . '.php');
        if ($viewFile === false || !str_starts_with($viewFile, $viewsDir . DIRECTORY_SEPARATOR)) {
            throw new HttpException(500, 'View not found: ' . $view);
        }

        $layoutFile = realpath($viewsDir . '/layouts/' . $layout . '.php');
        if ($layoutFile === false || !str_starts_with($layoutFile, $viewsDir . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR)) {
            throw new HttpException(500, 'Layout not found: ' . $layout);
        }

        $content = $this->capture($viewFile, $data);

        // layout gets $content + same $data
        return $this->capture($layoutFile, $data + ['content' => $content]);
    }

    private function capture(string $file, array $data): string
    {
        foreach (array_keys($data) as $key) {
            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', (string) $key)) {
                throw new \InvalidArgumentException("Invalid template variable name: $key");
            }
        }
        extract($data, EXTR_SKIP);

        ob_start();
        require $file;
        return (string)ob_get_clean();
    }
}