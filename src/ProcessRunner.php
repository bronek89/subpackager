<?php declare(strict_types=1);

namespace Bronek\SubPackager;

use Symfony\Component\Process\Process;

interface ProcessRunner
{
    public function run(Process $process, bool $quiet = false): Process;
}
