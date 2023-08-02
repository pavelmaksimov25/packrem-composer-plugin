<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\PackageRemover;

use SprykerSdk\SprykerFeatureRemover\Action\ActionInterface;
use SprykerSdk\SprykerFeatureRemover\Dto\ActionDto;
use SprykerSdk\SprykerFeatureRemover\Dto\PackageRemoveDto;
use SprykerSdk\SprykerFeatureRemover\Dto\PackageRemoveResult;

final class PackageRemover
{
    /**
     * @param iterable<ActionInterface> $actions
     */
    public function __construct(private iterable $actions)
    {
    }

    /**
     * @param PackageRemoveDto $packageRemoveDto
     *
     * @return PackageRemoveResult
     */
    public function removePackages(PackageRemoveDto $packageRemoveDto): PackageRemoveResult
    {
        $packageRemoveResult = new PackageRemoveResult();

        $actionDto = new ActionDto();
        $actionDto->setModuleNames($packageRemoveDto->getModuleNames());
        foreach ($this->actions as $action) {
            $action->act($actionDto);
            /*
             * todo(remove/update):
             *  - related plugins.
             *  - related configs.
             *  - related tests.
             *  - related business model highlight.
             */
        }

        if (count($actionDto->getErrorMessages()) > 0) {
            $packageRemoveResult->setIsOk(false);
            $packageRemoveResult->addMessages($actionDto->getErrorMessages());
        }

        return $packageRemoveResult;
    }
}
