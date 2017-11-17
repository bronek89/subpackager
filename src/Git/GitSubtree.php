<?php

namespace Bronek\SubPackager\Git;

final class GitSubtree
{
    /** @var GitHandle */
    private $gitHandle;

    public function __construct(GitHandle $gitHandle)
    {
        $this->gitHandle = $gitHandle;
    }

    public function split(string $prefix, string $destinationBranch): void
    {
        $this->gitHandle->run('subtree', 'split', "--prefix=$prefix", '-b', $destinationBranch);
    }
}
