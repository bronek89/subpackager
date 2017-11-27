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
        return new Json(\file_get_contents($filePath));
    }
}
