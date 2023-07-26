<?php

namespace SprykerSdk\SprykerFeatureRemover\Dto;

use Composer\Package\PackageInterface;

class PackageRemoveDto
{
    /**
     * @var array<string, PackageInterface>
     */
    private array $packages = [];

    /**
     * @var array<string>
     */
    private array $moduleNames = [];

    /**
     * @return array<PackageInterface>
     */
    public function getPackages(): array
    {
        return array_values($this->packages);
    }

    /**
     * @param array<PackageInterface> $packages
     */
    public function setPackages(array $packages): void
    {
        foreach ($packages as $package) {
            $this->addPackage($package);
        }
    }

    public function addPackage(PackageInterface $package): void
    {
        $this->packages[$package->getName()] = $package;
    }

    /**
     * @return array<string>
     */
    public function getPackageNames(): array
    {
        return array_keys($this->packages);
    }

    /**
     * @return array<string>
     */
    public function getModuleNames(): array
    {
        return $this->moduleNames;
    }

    /**
     * @param array<string> $moduleNames
     *
     * @return void
     */
    public function setModuleNames(array $moduleNames): void
    {
        $this->moduleNames = $moduleNames;
    }
}
