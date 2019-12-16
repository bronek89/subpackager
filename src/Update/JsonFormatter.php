<?php declare(strict_types=1);

namespace Bronek\SubPackager\Update;

use Bronek\SubPackager\Config\Package;
use Symfony\Component\Console\Output\OutputInterface;

final class JsonFormatter implements Formatter
{
    public function format(OutputInterface $output, UpdateResult $result): void
    {
        if (!$result->hasConfiguration()) {
            $output->writeln('{"status": "no_configuration"}');

            return;
        }

        $data = [
            'packages' => array_map(
                function (Package $package) use ($result): array {
                    return [
                        'repository' => $package->repository(),
                        'path' => $package->path(),
                        'pushed' => $result->isPackagePushed($package),
                    ];
                },
                $result->packages()
            ),
        ];

        $output->writeln(\json_encode($data, JSON_THROW_ON_ERROR, 512));
    }
}
