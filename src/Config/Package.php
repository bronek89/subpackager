<?php

namespace Bronek\SubPackager\Config;

final class Package
{
    /** @var string */
    private $path;

    /** @var string */
    private $repository;

    public function __construct(string $path, string $repository)
    {
        $this->path = $path;
        $this->repository = $repository;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function repository(): string
    {
        return $this->repository;
    }
}
