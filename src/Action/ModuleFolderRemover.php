<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Action;

use SprykerSdk\SprykerFeatureRemover\Adapter\RmModuleDirAdapter;
use SprykerSdk\SprykerFeatureRemover\Dto\ActionDto;

class ModuleFolderRemover implements ActionInterface
{
    public function __construct(private RmModuleDirAdapter $rmDirAdapter)
    {
    }

    /**
     * @return void
     */
    public function act(ActionDto $actionDto): void
    {
        $result = $this->rmDirAdapter->removeModuleDirectoryFromProjectSrc($actionDto->getModuleName());
        if (!$result) {
            $actionDto->addErrorMessage('Could not delete folders for the module ' . $actionDto->getModuleName());
        }

        $result = $this->rmDirAdapter->removeModuleDirectoryFromProjectOrm($actionDto->getModuleName());
        if (!$result) {
            $actionDto->addErrorMessage('Could not delete folders for the module ' . $actionDto->getModuleName());
        }
    }
}
