<?php declare(strict_types=1);

namespace Bronek\SubPackager\Update;

use Bronek\SubPackager\Config\Config;
use Bronek\SubPackager\Git\Git;

final class Update
{
    /** @var Config */
    private $config;

    /** @var Git */
    private $git;

    public function __construct(Config $config, Git $git)
    {
        $this->config = $config;
        $this->git = $git;
    }

    public function update(?string $from): UpdateResult
    {
        if (!$this->config->detectConfiguration()) {
            return UpdateResult::noConfiguration();
        }

        $git = $this->git->open('.');
        $to = $git->handle()->currentCommit();

        $gitDiff = $git->diff();
        $gitSubtree = $git->subtree();
        $gitPush = $git->push();

        $json = $this->config->read();
        $result = UpdateResult::withConfiguration($json);

        foreach ($json->packages() as $package) {
            if (!$from || $gitDiff->hasDirectoryChanged($package->path(), $from, $to)) {
                $destinationBranch = 'split/' . str_replace('/', '_', $package->path());
                $gitSubtree->split($package->path(), $destinationBranch);
                $gitPush->pushBranchTo($destinationBranch, $package->repository());
                $result->markPackageAsPushed($package);
            }
        }

        return $result;
    }
}
