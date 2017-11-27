<?php

namespace Bronek\SubPackager\Git;

use Bronek\SubPackager\QuietProcessRunner;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\ProcessBuilder;

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

        return file_get_contents($this->location.'/'.$filename);
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

    public function run(string $command, string ...$arguments): string
    {
        $processBuilder = new ProcessBuilder(array_merge(['git', '--no-pager', $command], $arguments));
        $processBuilder->setWorkingDirectory($this->location);

        $process = $processBuilder->getProcess();
        (new QuietProcessRunner())->run($process);

        if (!$process->isSuccessful()) {
            throw new \RuntimeException(
                sprintf("Failed command: %s: \n%s", $process->getCommandLine(), $process->getErrorOutput())
            );
        }

        return trim($process->getOutput());
    }

    public function currentCommit(): string
    {
        return $this->run('rev-parse', 'HEAD');
    }
}
