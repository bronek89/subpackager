<?php

namespace Bronek\SubPackager\Git;

final class Git
{
    /** @var GitHandle */
    private $handle;

    public function open(string $location): Git
    {
        $instance = new self();
        $instance->handle = new GitHandle($location);

        return $instance;
    }

    public function handle(): GitHandle
    {
        return $this->handle ?? ($this->handle = new GitHandle('.'));
    }

    public function diff(): GitDiff
    {
        return new GitDiff($this->handle());
    }

    public function push(): GitPush
    {
        return new GitPush($this->handle());
    }

    public function subtree(): GitSubtree
    {
        return new GitSubtree($this->handle());
    }
}
