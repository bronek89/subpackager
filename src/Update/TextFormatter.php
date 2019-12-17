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
                $pushInfo = 'not pushed';

                if ($result->isPackagePushed($package)) {
                    $pushInfo = 'pushed to ' . $package->repository();
                } elseif ($result->isPackageNotModified($package)) {
                    $pushInfo = 'not modified';
                }

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
