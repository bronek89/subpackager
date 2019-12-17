<?php

namespace Bronek\SubPackager\Git;

use Bronek\SubPackager\QuietProcessRunner;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

final class GitHandle
{
    /** @var string */
    private $location;

    public function __construct(string $location)
    {
        $this->location = rtrim($location, '/');

        if (!file_exists($this->location.'/.git')) {
            throw new \RuntimeException(sprintf('Location %s is not valid git repository.', $location));
        }
    }

    public function location(): string
    {
        return $this->location;
    }

    public function fileContents(string $filename): string
    {
        if (!file_exists($this->location.'/'.$filename)) {
            throw new \RuntimeException(sprintf('File %s not found in repository.', $filename));
        }

        $contents = file_get_contents($this->location . '/' . $filename);

        if ($contents === false) {
            throw new \RuntimeException(sprintf('Cannot load file %s', $filename));
        }

        return $contents;
    }

    public function copy(string $path, string $destination): void
    {
        $path = rtrim($path, '/');

        if (!file_exists($this->location.'/'.$path)) {
            throw new \RuntimeException(sprintf('File %s not found in repository.', $path));
        }

        $filesystem = new Filesystem();
        $filesystem->mirror($this->location . '/' . $path, $destination);
    }

    public function run(string $command, string ...$arguments): Process
    {
        $process = new Process(array_merge(['git', '--no-pager', $command], $arguments));
        $process->setWorkingDirectory($this->location);

        (new QuietProcessRunner())->run($process);

        if (!$process->isSuccessful()) {
            throw new \RuntimeException(
                sprintf("Failed command: %s: \n%s", $process->getCommandLine(), $process->getErrorOutput())
            );
        }

        return $process;
    }

    public function currentCommit(): string
    {
        return trim($this->run('rev-parse', 'HEAD')->getOutput());
    }
}
