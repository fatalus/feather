<?php

declare(strict_types = 1);

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
        $this->uri = $_SERVER['REQUEST_URI'] ?? "";
        $this->method = $_SERVER['REQUEST_METHOD'] ?? "";
        $this->host = $_SERVER['HTTP_HOST'] ?? "";
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'] ?? "";
        $this->request_time = $_SERVER['REQUEST_TIME'] ?? 0;
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

    public function getQueryParams(): array
    {
        return $_GET;
    }

    public function getPostParams(): array
    {
        return $_POST;
    }

    public function getRawBody(): string
    {
        return file_get_contents('php://input');
    }

    public function getJsonBody(): array
    {
        $data = json_decode($this->getRawBody(), true);

        return is_array($data) ? $data : [];
    }
}