<?php declare(strict_types=1);

namespace Bronek\SubPackager\Update;

use Symfony\Component\Console\Output\OutputInterface;

final class UpdateCommand
{
    /** @var Update */
    private $update;

    /** @var Responder */
    private $responder;

    public function __construct(Update $update, Responder $responder)
    {
        $this->update = $update;
        $this->responder = $responder;
    }

    public function __invoke(?string $from, string $formatter, OutputInterface $output): void
    {
        $formatterObj = $this->responder->useFormatter($formatter);
        $formatterObj->format($output, $this->update->update($from));
    }
}
