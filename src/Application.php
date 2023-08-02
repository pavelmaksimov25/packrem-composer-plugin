<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover;

use Composer\Composer;
use Composer\Installer\PackageEvent;
use SprykerSdk\SprykerFeatureRemover\Config\Config;
use SprykerSdk\SprykerFeatureRemover\Dto\PackageRemoveDto;
use SprykerSdk\SprykerFeatureRemover\Dto\PackageRemoveResult;
use SprykerSdk\SprykerFeatureRemover\Factory\PackRemFactory;

final class Application
{
    private Config $config;

    private PackRemFactory $factory;

    public function __construct(Composer $composer)
    {
        $this->config = $this->bootConfiguration($composer);
        $this->factory = new PackRemFactory($this->config);
    }

    private function bootConfiguration(Composer $composer): Config
    {
        $extra = $composer->getPackage()->getExtra();
        $projectNamespace = $extra[Config::KEY_PROJECT_NAMESPACE] ?? Config::PROJECT_NAMESPACE_DEFAULT;

        return new Config($projectNamespace);
    }

    final public function run(PackageEvent $event): PackageRemoveResult
    {
        $resultDto = new PackageRemoveResult();
        $packages = $this->factory->createPackageExtractor()->extractPackages($event);
        if (count($packages) === 0) {
            return $resultDto;
        }

        $packageRemoveDto = new PackageRemoveDto();
        $packageRemoveDto->setPackages($packages);

        $validationResultDto = $this->factory
            ->createPackageValidator()
            ->isValidListOfPackages($packageRemoveDto);

        if (!$validationResultDto->isOk()) {
            $resultDto->setIsOk(false);
            $resultDto->addMessages([$validationResultDto->getMessage()]);

            return $resultDto;
        }

        $this->factory
            ->createSprykerModuleResolver()
            ->expandWithFeatureModuleNames($packageRemoveDto);

        return $this->factory
            ->createPackageRemover()
            ->removePackages($packageRemoveDto);
    }
}
