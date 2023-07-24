<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\PackageRemover;

use SprykerSdk\SprykerFeatureRemover\Action\ActionInterface;
use SprykerSdk\SprykerFeatureRemover\Dto\ActionDto;
use SprykerSdk\SprykerFeatureRemover\Dto\PackageRemoveResult;

class PackageRemover
{
    /**
     * @param iterable<ActionInterface> $actions
     */
    public function __construct(private iterable $actions)
    {
    }

    /**
     * @param $packages array<string>
     *
     * @return mixed ResponseDto
     * @todo use dto
     *
     */
    public function removePackages(array $packages): PackageRemoveResult
    {
        $packageRemoveResult = new PackageRemoveResult();

        // package remove
        // todo :: refactor to action per packages
        foreach ($packages as $package) {
            $actionDto = new ActionDto();
            $actionDto->setModuleName($package);
            foreach ($this->actions as $action) {
                $action->act($actionDto);
            }
            if (count($actionDto->getErrorMessages()) > 0) {
                $packageRemoveResult->setIsOk(false);
                $packageRemoveResult->addMessages($actionDto->getErrorMessages());
            }

            /* package post-remove hook
             * Removes:
             *  - related plugins.
             *  - related configs.
             *      - cron jobs
             *      - oms
             *      - state machine
             *      - data?
             *  - related tests.
             *  - related folders on the project level.
             *  - related generated data.
             *  - related ORM data. Remove from src/Orm/*
             */
        }

        return new PackageRemoveResult();
    }
}
