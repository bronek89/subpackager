<?php declare(strict_types=1);

namespace Bronek\SubPackager\Update;

use Symfony\Component\Console\Output\OutputInterface;

interface Formatter
{
    public function format(OutputInterface $output, UpdateResult $result): void;
}
