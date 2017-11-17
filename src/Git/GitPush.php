<?php

namespace Bronek\SubPackager\Git;

final class GitPush
{
    /** @var GitHandle */
    private $gitHandle;

    public function __construct(GitHandle $gitHandle)
    {
        $this->gitHandle = $gitHandle;
    }

    public function pushBranchTo(string $branch, string $remote, string $remoteBranch = 'master'): void
    {
        $this->gitHandle->run('push', $remote, "$branch:$remoteBranch");
    }
}
