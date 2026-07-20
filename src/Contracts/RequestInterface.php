<?php

declare(strict_types = 1);

namespace Feather\Contracts;

interface RequestInterface {
    public function getRequestUri(): string;
    public function getRequestMethod(): string;
    public function getHost(): string;
    public function getUserAgent(): string;
    public function getRequestTime(): int;
}