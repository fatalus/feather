<?php

declare(strict_types = 1);

namespace Feather\Contracts;

interface RequestInterface {
    public function getRequestUri(): string;
    public function getRequestMethod(): string;
    public function getHost(): string;
    public function getUserAgent(): string;
    public function getRequestTime(): int;

    /**
     * Returns all GET parameters
     * @return array<string, string>
     */
    public function getQueryParams(): array;

    /**
     * @return array<string, string|int>
     */
    public function getPostParams(): array;
    public function getRawBody(): string;

    /**
     * @return array<string, string|int>
     */
    public function getJsonBody(): array;
}
