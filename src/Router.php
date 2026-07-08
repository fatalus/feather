<?php

declare(strict_types=1);

namespace Feather;

use Feather\Engine;
use Feather\Contracts\RoutingInterface;

class Router implements RoutingInterface
{
    private const string ROUTE_PATH = FEATHER_ROOT . '/routes.php';

    public static function getRoutes(): array
    {
        return require_once self::ROUTE_PATH;
    }

    public function route(string $uri, string $request_method = 'GET'): string
    {
        // For now we'll only handle GET Routing
        $path = parse_url($uri, PHP_URL_PATH);

        foreach (self::getRoutes() as $route => $handler) {
            $pattern = $this->resolveRoute($route);

            if (preg_match($pattern, $path, $matches)) {
                return $handler($matches);
            }
        }

        http_response_code(404);
        return Engine::render("404");
    }

    private function resolveRoute(string $route): string
    {
        $pattern = preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            fn($matches) => '(?<' . $matches[1] . '>[^/]+)',
            $route
        );

        return '#^' . $pattern . '$#';
    }
}

