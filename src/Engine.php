<?php

declare(strict_types=1);

namespace Feather;

use Exception;

/**
 * Simple templating Engine
 */
class Engine
{
    /** @var array<string, string> */
    private array $sections = [];

    /** @var array<int, string> */
    private array $section_stack = [];
    
    private ?string $layout = null;
    
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

    /**
     * Renders a template
     * @param string $template
     * @param array<string, mixed> $data
     * @return string
     */
    public function render(string $template, array $data = []): string
    {
        $this->layout = null;
        $this->sections = [];

        $content = $this->renderFile($template, $data);

        if ($this->layout !== null) {
            return $this->renderFile($this->layout, $data);
        }

        return $content;
    }

    /**
     * @internal renders the file of the give template
     * @phpstan-impure
     * @param string $template
     * @param array<string, mixed> $data
     * @return string
     */
    private function renderFile(string $template, array $data): string
    {
        $path = self::$TEMPLATE_PATH . $template . '.phtml';
        if (!file_exists($path) || !is_readable($path)) {
            $fallback = self::$FALLBACK_TEMPLATE_PATH . $template . '.pthml';
            if (file_exists($path) && is_readable($path)) {
                $path = $fallback;
            } else {
                $path = self::$FALLBACK_TEMPLATE_PATH . '404.phtml';
            }
        }

        extract($data);

        ob_start();

        require $path;

        $ob_clean = ob_get_clean();

        return $ob_clean !== false ? $ob_clean : "";
    }

    public function extend(string $layout): void
    {
        $this->layout = $layout;
    }

    public function start(string $name): void
    {
        $this->section_stack[] = $name;
        ob_start();
    }
    
    public function end(): void
    {
        $name = array_pop($this->section_stack);

        if ($name === null) {
            throw new Exception('Cannot end a section with no active section.');
        }

        $ob_clean = ob_get_clean();
        $this->sections[$name] = $ob_clean !== false ? $ob_clean : "";
    }

    public function yield(string $name, string $default = ''): string
    {
        return $this->sections[$name] ?? $default;
    }

    /**
     * Placeholder to render a section in a tempalte
     * @param string $template
     * @param array<string, mixed> $data
     * @return void
     */
    public function include(string $template, array $data = []): void
    {
        echo $this->renderFile($template, $data);
    }
}
