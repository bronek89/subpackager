<?php

namespace Bronek\SubPackager\Config;

final class Config
{
    public function detectConfiguration(string $filePath = 'subpackager.json'): bool
    {
        return file_exists($filePath);
    }

    public function read(string $filePath = 'subpackager.json'): Json
    {
        $content = \file_get_contents($filePath);

        if ($content === false) {
            throw new \RuntimeException(sprintf('Cannot load config file %s', $filePath));
        }

        return new Json($content);
    }
}
