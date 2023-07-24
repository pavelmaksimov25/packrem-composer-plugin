<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Validator;

use Composer\InstalledVersions;
use SprykerSdk\SprykerFeatureRemover\Dto\PackageInputValidationResult;

class PackageValidator
{
    public function isValidListOfPackages(array $packageList): PackageInputValidationResult
    {
        $result = new PackageInputValidationResult();

        foreach ($packageList as $package) {
            if (!$this->isSprykerPackage($package)) {
                $result->setIsOk(false);
                $result->setMessage("$package is not spryker package.");

                return $result;
            }

            if (!$this->isPackageInstalled($package)) {
                $result->setIsOk(false);
                $result->setMessage("$package is not installed.");

                return $result;
            }
        }

        return $result;
    }

    private function isSprykerPackage(string $packageName): bool
    {
        return (bool)preg_match('/^spryker/', strtolower($packageName));
    }

    private function isPackageInstalled(string $packageName): bool
    {
        return InstalledVersions::isInstalled($packageName);
    }
}
