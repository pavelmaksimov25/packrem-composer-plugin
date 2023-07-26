<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Validator;

use Composer\InstalledVersions;
use SprykerSdk\SprykerFeatureRemover\Dto\PackageInputValidationResult;
use SprykerSdk\SprykerFeatureRemover\Dto\PackageRemoveDto;

class PackageValidator
{
    public function isValidListOfPackages(PackageRemoveDto $packageRemoveDto): PackageInputValidationResult
    {
        $result = new PackageInputValidationResult();

        foreach ($packageRemoveDto->getPackageNames() as $packageName) {
            if (!$this->isSprykerPackage($packageName)) {
                $result->setIsOk(false);
                $result->setMessage("$packageName is not spryker package.");

                return $result;
            }

            if (!$this->isPackageInstalled($packageName)) { // todo :: remove uninstalled files from the PackageRemoveDto. shouldn't be in the validator
                $result->setIsOk(false);
                $result->setMessage("$packageName is not installed.");

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
