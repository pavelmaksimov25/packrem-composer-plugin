<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Adapter;

use Composer\Composer;

class ComposerAdapter
{
    /**
     * @param string $packageName
     *
     * @return array<string>
     */
    public function getListOfPackageDependencies(string $packageName): array
    {

    }

    /**
     * @param array<string> $packages
     *
     * @return array<string>
     */
    public function sprykerPackagesOnly(array $packages): array
    {
        return array_filter(
            $packages,
            fn($packageName): bool => str_contains($packageName, 'spryker'),
        );
    }
}
