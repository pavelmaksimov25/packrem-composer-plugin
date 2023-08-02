<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Adapter;

use Composer\InstalledVersions;
use Composer\Package\PackageInterface;

class ComposerAdapter
{
    /**
     * @param PackageInterface $package
     *
     * @return array
     */
    public function getListOfPackageDependencies(PackageInterface $package): array
    {
        $packages = array_merge(
            array_keys($package->getRequires()),
            array_keys($package->getDevRequires()),
        );

        return $this->filterSprykerPackagesOnly($packages);
    }

    /**
     * @param array<string> $packages
     *
     * @return array<string>
     */
    private function filterSprykerPackagesOnly(array $packages): array
    {
        return array_filter(
            $packages,
            fn($packageName): bool => str_contains($packageName, 'spryker'),
        );
    }

    public function isPackageInstalled(string $packageName): bool
    {
        return InstalledVersions::isInstalled($packageName);
    }
}
