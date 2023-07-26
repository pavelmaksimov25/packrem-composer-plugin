<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Action;

use SprykerSdk\SprykerFeatureRemover\Dto\ActionDto;
use SprykerSdk\SprykerFeatureRemover\FilesRemover\SprykerFilesRemover;

final class ModuleFolderRemover implements ActionInterface
{
    public function __construct(private SprykerFilesRemover $sprykerFilesRemover)
    {
    }

    /**
     * @return void
     */
    final public function act(ActionDto $actionDto): void
    {
        foreach ($actionDto->getModuleNames() as $moduleName) {
            $result = $this->sprykerFilesRemover->removeModuleDirectoryFromProject($moduleName);
            if (!$result) {
                $actionDto->addErrorMessage('Could not delete folders from project for the module ' . $moduleName);
            }

            $result = $this->sprykerFilesRemover->removeModuleDirectoryFromOrm($moduleName);
            if (!$result) {
                $actionDto->addErrorMessage('Could not delete folders from `Orm` folder for the module ' . $moduleName);
            }
        }
    }
}
