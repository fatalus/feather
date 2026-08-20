<?php

declare(strict_types=1);

namespace Feather;

use Feather\Contracts\RequestInterface;

class Request implements RequestInterface
{
    private string $uri;
    private string $method;
    private string $host;
    private string $user_agent;
    private int $request_time;

    public function __construct()
    {
        // This is awful, just to be PHPStan max level compliant...
    
        $this->uri = is_string($_SERVER['REQUEST_URI'] ?? null)
            ? $_SERVER['REQUEST_URI']
            : '';

        $this->method = is_string($_SERVER['REQUEST_METHOD'] ?? null)
            ? $_SERVER['REQUEST_METHOD']
            : '';

        $this->host = is_string($_SERVER['HTTP_HOST'] ?? null)
            ? $_SERVER['HTTP_HOST']
            : '';

        $this->user_agent = is_string($_SERVER['HTTP_USER_AGENT'] ?? null)
            ? $_SERVER['HTTP_USER_AGENT']
            : '';

        $this->request_time = is_int($_SERVER['REQUEST_TIME'] ?? null)
            ? $_SERVER['REQUEST_TIME']
            : 0;
    }

    public function getRequestUri(): string
    {
        return $this->uri;
    }

    public function getRequestMethod(): string
    {
        return $this->method;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getUserAgent(): string
    {
        return $this->user_agent;
    }

    public function getRequestTime(): int
    {
        return $this->request_time;
    }

    /**
     * Returns all GET parameters
     * @return array<string, mixed>
     */
    public function getQueryParams(): array
    {
        return $_GET;
    }

    /**
     * @return array<string, mixed>
     */
    public function getPostParams(): array
    {
        return $_POST;
    }

    public function getRawBody(): string
    {
        return file_get_contents('php://input');
    }

    /**
     * @return array<string, string|int>
     */
    public function getJsonBody(): array
    {
        $data = json_decode($this->getRawBody(), true);

        return is_array($data) ? $data : [];
    }
}
