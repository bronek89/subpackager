<?php declare(strict_types=1);

namespace Bronek\SubPackager\Update;

use Bronek\SubPackager\Config\Json;
use Bronek\SubPackager\Config\Package;

final class UpdateResult
{
    /** @var Json */
    private $configuration;

    /** @var Package[] */
    private $pushedPackages = [];

    /** @var Package[] */
    private $notModifiedPackages = [];

    public function __construct(?Json $json)
    {
        $this->configuration = $json ?? Json::empty();
    }

    public static function noConfiguration(): UpdateResult
    {
        return new self(null);
    }

    public static function withConfiguration(Json $json): UpdateResult
    {
        return new self($json);
    }

    public function markPackageAsPushed(Package $package): void
    {
        $this->pushedPackages[] = $package;
    }

    public function markPackageAsNotModified(Package $package): void
    {
        $this->notModifiedPackages[] = $package;
    }

    public function hasConfiguration(): bool
    {
        return $this->configuration !== null;
    }

    public function isPackagePushed(Package $package): bool
    {
        return \in_array($package, $this->pushedPackages, false);
    }

    public function isPackageNotModified(Package $package): bool
    {
        return \in_array($package, $this->notModifiedPackages, false);
    }

    /**
     * @return Package[]
     */
    public function packages(): array
    {
        return $this->configuration->packages();
    }
}
