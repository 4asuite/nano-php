<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Class representing an HTTP response.
 */
final class Response
{
    private int $status = 200;
    private array $headers = [];
    private string $body = '';

    public function status(int $code): self
    {
        $this->status = $code;
        return $this;
    }

    public function header(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function body(string $content): self
    {
        $this->body = $content;
        return $this;
    }

    public function html(string $content, int $status = 200): self
    {
        return $this
            ->status($status)
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->body($content);
    }

    public function json(mixed $data, int $status = 200): self
    {
        return $this
            ->status($status)
            ->header('Content-Type', 'application/json; charset=UTF-8')
            ->body((string) json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    public function redirect(string $url, int $code = 302): self
    {
        if (preg_match('#^https?://#i', $url)) {
            $host = parse_url($url, PHP_URL_HOST);
            $currentHost = $_SERVER['HTTP_HOST'] ?? '';
            if ($host !== $currentHost) {
                throw new \InvalidArgumentException('External redirects are not allowed.');
            }
        }

        return $this
            ->status($code)
            ->header('Location', $url);
    }

    public function send(): void
    {
        http_response_code($this->status);

        $securityHeaders = [
            'X-Frame-Options'           => 'SAMEORIGIN',
            'X-Content-Type-Options'    => 'nosniff',
            'Referrer-Policy'           => 'strict-origin-when-cross-origin',
            'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
        ];

        foreach ($securityHeaders as $key => $value) {
            if (!isset($this->headers[$key])) {
                header("$key: $value");
            }
        }

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        echo $this->body;
        exit;
    }
}
