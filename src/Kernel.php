<?php

namespace Feather;

use Feather\Router;
use Feather\Request;
use Feather\Contracts\RoutingInterface;
use Feather\Contracts\RequestInterface;
use Exception;

class Kernel
{
    private RoutingInterface $router;
    private RequestInterface $request;

    public function __construct(
        RoutingInterface $router = new Router(),
        RequestInterface $request = new Request()
    ) {
        $this->router = $router;
        $this->request = $request;
    
        if (!defined('FEATHER_ROOT')) {
            throw new Exception("Root path no specified!");
        }
    }

    public function handle(): string
    {
        // TODO: allow alteration via config file, similar to dev.php
        $allowed_methods = ['GET', 'HEAD', 'POST', 'PUT', 'DELETE'];

        if (!in_array($this->request->getRequestMethod(), $allowed_methods, true)) {
            http_response_code(405);
            header('Content-Type: application/json');

            echo json_encode([
                'error' => 'Method not allowed.'
            ]);

            exit(1);
        }

        if (file_exists(FEATHER_ROOT . '/development.php')) {
            require_once FEATHER_ROOT . '/development.php';
        }

        return $this->router->route($this->request->getRequestUri(), $this->request->getRequestMethod());
    }
}
