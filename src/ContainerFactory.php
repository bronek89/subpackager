<?php declare(strict_types=1);

namespace Bronek\SubPackager;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

final class ContainerFactory
{
    private static function services(): array
    {
        return [];
    }

    public static function build(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions(self::services());

        return $containerBuilder->build();
    }
}
