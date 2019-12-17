<?php

namespace Bronek\SubPackager\Git;

final class GitPush
{
    public const PUSH_OK = 1;
    public const PUSH_NOT_MODIFIED = 2;

    /** @var GitHandle */
    private $gitHandle;

    public function __construct(GitHandle $gitHandle)
    {
        $this->gitHandle = $gitHandle;
    }

    public function pushBranchTo(string $branch, string $remote, string $remoteBranch = 'master'): int
    {
        $result = $this->gitHandle->run('push', $remote, "$branch:$remoteBranch");

        if (trim($result->getErrorOutput()) === 'Everything up-to-date') {
            return self::PUSH_NOT_MODIFIED;
        }

        return self::PUSH_OK;
    }
}
