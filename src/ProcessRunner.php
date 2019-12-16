<?php declare(strict_types=1);

namespace Bronek\SubPackager;

use Symfony\Component\Process\Process;

interface ProcessRunner
{
    /**
     * @phpstan-param Process<int, string> $process
     * @phpstan-return Process<int, string>
     */
    public function run(Process $process, bool $quiet = false): Process;
}
