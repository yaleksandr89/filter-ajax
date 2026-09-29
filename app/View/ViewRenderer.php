<?php

declare(strict_types=1);

namespace App\View;

use RuntimeException;
use Throwable;

final readonly class ViewRenderer
{
    private const array TEMPLATES = [
        'layout' => 'layout.php',
        'home' => 'home.php',
        'products' => 'products.php',
    ];

    private string $templateRoot;

    public function __construct(string $templateRoot)
    {
        $resolvedRoot = realpath($templateRoot);
        if ($resolvedRoot === false || !is_dir($resolvedRoot)) {
            throw new RuntimeException('The template root is invalid.');
        }

        $this->templateRoot = $resolvedRoot;
    }

    /**
     * @param array<string, mixed> $data
     * @throws Throwable When template execution fails.
     */
    public function render(string $template, array $data = []): string
    {
        if (!isset(self::TEMPLATES[$template])) {
            throw new RuntimeException('The requested internal template is not registered.');
        }

        $file = $this->templateRoot . DIRECTORY_SEPARATOR . self::TEMPLATES[$template];
        if (!is_file($file) || !is_readable($file)) {
            throw new RuntimeException('The requested internal template is unavailable.');
        }

        extract($data, EXTR_SKIP);
        ob_start();

        try {
            include $file;

            return (string) ob_get_clean();
        } catch (Throwable $exception) {
            ob_end_clean();
            throw $exception;
        }
    }

    public function escape(mixed $value): string
    {
        return htmlspecialchars(
            (string) $value,
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8',
        );
    }
}
