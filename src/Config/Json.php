<?php

namespace Bronek\SubPackager\Config;

final class Json
{
    /** @var array[] */
    private $configuration;

    public function __construct(string $json)
    {
        $this->configuration = \json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    public static function empty(): self
    {
        return new self('[]');
    }

    /**
     * @return Package[]
     */
    public function packages(): array
    {
        return array_map(
            function (array $package): Package {
                return new Package($package['path'], $package['repository']);
            },
            $this->configuration['packages'] ?? []
        );
    }
}
