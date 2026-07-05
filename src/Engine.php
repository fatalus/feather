<?php

declare(strict_types=1);

namespace Feather;

/**
 * Simple templating Engine
 */
class Engine
{
    /**
     * Path to where all templates are stored in the project.
     * @var string
     */
    private static string $TEMPLATE_PATH = FEATHER_ROOT . '/templates/';

    /**
     * Fall back path e.g. for default templates like 404
     * @var string
     */
    private static string $FALLBACK_TEMPLATE_PATH = __DIR__ . '/templates/';

    public static function render(string $template, array $data = []): string
    {
        $template_path = self::$TEMPLATE_PATH . $template . '.phtml';
        $fallback = self::$FALLBACK_TEMPLATE_PATH . "404.phtml";

        // if the file can't be read fall back to the 404 template
        if (!file_exists($template_path) || !is_readable($template_path)) {
            http_response_code(404);
            $template_path = $fallback;
        }

        extract($data);

        ob_start();
        require $template_path;
        return ob_get_clean();
    }
}

