<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Resolver;

use Composer\Package\PackageInterface;
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
        foreach ($packageRemoveDto->getPackages() as $package) {
            $modulesNames[] = $this->resolveModulesNamesForSinglePackage($package);
        }

        $modulesNames = array_merge([], ...$modulesNames);

        $packageRemoveDto->setModuleNames(array_unique($modulesNames));
    }

    /**
     * @param PackageInterface $package
     *
     * @return array<string>
     */
    private function resolveModulesNamesForSinglePackage(PackageInterface $package): array
    {
        $modules = [];
        $dependencies = $this->composerAdapter->getListOfPackageDependencies($package);
        foreach ($dependencies as $dependency) {
            if ($this->isFeaturePackage($dependency)) {
                continue;
            }

            $modules[] = $this->resolveRegularModuleNameByPackageName($dependency);
        }

        return $modules;
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
