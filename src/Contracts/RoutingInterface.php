<?php

declare(strict_types = 1);

namespace Feather\Contracts;

interface RoutingInterface {
    public function route(string $uri, string $request_method = 'GET'): string;
}