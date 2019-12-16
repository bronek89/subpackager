<?php declare(strict_types=1);

namespace Bronek\SubPackager\Update;

final class Responder
{
    /**
     * @var string[]
     * @phpstan-var array<string, class-string>
     */
    private static $formatters = [
        'json' => JsonFormatter::class,
        'text' => TextFormatter::class,
    ];

    public function useFormatter(string $name): Formatter
    {
        return new self::$formatters[$name]();
    }
}
