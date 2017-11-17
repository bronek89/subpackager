<?php declare(strict_types=1);

namespace Bronek\SubPackager;

use Symfony\Component\Process\Process;

final class QuietProcessRunner implements ProcessRunner
{
    public function run(Process $process, bool $quiet = false): Process
    {
        $process->run();

        return $process;
    }
}
