<?php declare(strict_types=1);

namespace Bronek\SubPackager;

use DI\ContainerBuilder;
use DI\Definition\Source\DefinitionSource;
use Psr\Container\ContainerInterface;

final class ContainerFactory
{
    /**
     * @return string[]|DefinitionSource[]
     */
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
