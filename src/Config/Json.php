<?php

namespace Bronek\SubPackager\Config;

final class Json
{
    /** @var array[] */
    private $configuration;

    public function __construct(string $json)
    {
        $this->configuration = \json_decode($json, true);
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
