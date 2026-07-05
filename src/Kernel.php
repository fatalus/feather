<?php

namespace Feather;

use Feather\Router;
use Exception;

class Kernel
{
    private Router $router;

    public function __construct() {
        $this->router = new Router();
    
        if (!defined('FEATHER_ROOT')) {
            throw new Exception("Root path no specified!");
        }
    }

    public function handle(array $server): string
    {
        // TODO: allow alteration via config file, similar to dev.php
        $allowed_methods = ['GET', 'HEAD', 'POST', 'PUT', 'DELETE'];
        $request_method = $server['REQUEST_METHOD'];

        if (!in_array($request_method, $allowed_methods, true)) {
            http_response_code(405);
            header('Content-Type: application/json');

            echo json_encode([
                'error' => 'Method not allowed.'
            ]);

            exit(1);
        }

        $request_uri = $server['REQUEST_URI'];

        if (file_exists(FEATHER_ROOT . '/development.php')) {
            require_once FEATHER_ROOT . '/development.php';
        }

        return $this->router->route($request_uri, $request_method);
    }
}
