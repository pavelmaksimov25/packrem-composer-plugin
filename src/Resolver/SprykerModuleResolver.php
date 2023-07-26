<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Resolver;

use SprykerSdk\SprykerFeatureRemover\Adapter\ComposerAdapter;
use SprykerSdk\SprykerFeatureRemover\Dto\PackageRemoveDto;

class SprykerModuleResolver
{
    public function __construct(private ComposerAdapter $composerAdapter)
    {
    }

    /**
     * @param PackageRemoveDto $packageRemoveDto
     *
     * @return void
     */
    public function expandWithFeatureModuleNames(PackageRemoveDto $packageRemoveDto): void
    {
        $modulesNames = [];
        foreach ($packageRemoveDto->getPackageNames() as $packageName) {
            $modulesNames[] = $this->resolveModulesNamesForSinglePackage($packageName);
        }

        $modulesNames = array_merge([], ...$modulesNames);

        $packageRemoveDto->setModuleNames(array_unique($modulesNames));
    }

    /**
     * @param string $packageName
     *
     * @return array<string>
     */
    private function resolveModulesNamesForSinglePackage(string $packageName): array
    {
        $dependencies = [];
        $packages = $this->composerAdapter->getListOfPackageDependencies($packageName);
        $packages = $this->composerAdapter->sprykerPackagesOnly($packages);
        foreach ($packages as $package) {
            if ($this->isFeaturePackage($package)) {
                continue;
            }

            $dependencies[] = $this->resolveRegularModuleNameByPackageName($package);
        }

        return $dependencies;
    }

    private function isFeaturePackage(string $packageName): bool
    {
        return str_starts_with(strtolower($packageName), 'spryker-feature');
    }

    private function resolveRegularModuleNameByPackageName(string $packageName): string
    {
        $packageName = basename($packageName);
        $packageName = ucwords($packageName, '-');

        return str_replace('-', '', $packageName);
    }
}
