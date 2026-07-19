<?php

declare(strict_types=1);

namespace Feather;

use Feather\Engine;
use Feather\Contracts\RoutingInterface;

class Router implements RoutingInterface
{
    private const string ROUTE_PATH = FEATHER_ROOT . '/routes.php';

    private Engine $engine;

    public function __construct() {
        $this->engine = new Engine();
    }

    public static function getRoutes(): array
    {
        return require_once self::ROUTE_PATH;
    }

    public function route(string $uri, string $request_method = 'GET'): string
    {
        $request_method === "HEAD" ? $request_method = "GET" : null;

        $path = parse_url($uri, PHP_URL_PATH);

        $routes = self::getRoutes()[$request_method] ?? [];

        foreach ($routes as $route => $handler) {
            $pattern = $this->resolveRoute($route);

            if (preg_match($pattern, $path, $matches)) {
                return $handler($matches);
            }
        }

        // wrong Method not allowed exception

        http_response_code(404);
        return $this->engine->render('404');
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

