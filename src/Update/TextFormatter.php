<?php declare(strict_types=1);

namespace Bronek\SubPackager\Update;

use Bronek\SubPackager\Config\Package;
use Symfony\Component\Console\Output\OutputInterface;

final class TextFormatter implements Formatter
{
    public function format(OutputInterface $output, UpdateResult $result): void
    {
        if (!$result->hasConfiguration()) {
            $output->writeln('No configuration detected, please create subpackager.json file');

            return;
        }

        $packagesInfo = array_map(
            function (Package $package) use ($result): string {
                $pushed = $result->isPackagePushed($package);
                $pushInfo = $pushed ? 'pushed to ' . $package->repository() : 'not pushed';

                return sprintf('%s: %s', $package->path(), $pushInfo);
            },
            $result->packages()
        );

        $output->writeln('Packages: ');

        foreach ($packagesInfo as $package) {
            $output->writeln(' - ' . $package);
        }
    }
}
