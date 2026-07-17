<?php

declare(strict_types=1);

namespace Feather;

/**
 * Simple templating Engine
 */
class Engine
{
    private array $sections = [];

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

    private function renderFile(string $template, array $data): string
    {
        $path = self::$TEMPLATE_PATH . $template . '.phtml';

        extract($data);

        ob_start();

        require $path;

        return ob_get_clean();
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

        $this->sections[$name] = ob_get_clean();
    }

    public function yield(string $name, string $default = ''): string
    {
        return $this->sections[$name] ?? $default;
    }

    public function include(string $template, array $data = []): void
    {
        echo $this->renderFile($template, $data);
    }
}

