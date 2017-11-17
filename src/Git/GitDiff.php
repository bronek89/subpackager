<?php

namespace Bronek\SubPackager\Git;

final class GitDiff
{
    /** @var GitHandle */
    private $gitHandle;

    public function __construct(GitHandle $gitHandle)
    {
        $this->gitHandle = $gitHandle;
    }

    /**
     * @return string[]
     */
    public function between(string $from, string $to): array
    {
        $result = $this->gitHandle->run('diff', $from, ' ', $to, '--name-only', '--no-prefix');

        return array_map('trim', explode("\n", $result));
    }

    public function hasDirectoryChanged(string $directory, string $from, string $to): bool
    {
        foreach ($this->between($from, $to) as $filePath) {
            if (strpos($filePath, $directory) === 0) {
                return true;
            }
        }

        return false;
    }
}
