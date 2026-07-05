<?php

declare(strict_types=1);

namespace Feather;

use Feather\Engine;

class Router
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

        foreach (self::getRoutes() as $pattern => $handler) {
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $path, $matches)) {
                return $handler($matches);
            }
        }

        http_response_code(404);
        return Engine::render("404");
    }
}

