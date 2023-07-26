<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Action;

use SprykerSdk\SprykerFeatureRemover\Dto\ActionDto;
use SprykerSdk\SprykerFeatureRemover\FilesRemover\SprykerFilesRemover;

class ModuleFolderRemover implements ActionInterface
{
    public function __construct(private SprykerFilesRemover $sprykerFilesRemover)
    {
    }

    /**
     * @return void
     */
    public function act(ActionDto $actionDto): void
    {
        foreach ($actionDto->getModuleNames() as $moduleName) {
            $result = $this->sprykerFilesRemover->removeModuleDirectoryFromProjectSrc($moduleName);
            if (!$result) {
                $actionDto->addErrorMessage('Could not delete folders for the module ' . $moduleName);
            }

            $result = $this->sprykerFilesRemover->removeModuleDirectoryFromProjectOrm($moduleName);
            if (!$result) {
                $actionDto->addErrorMessage('Could not delete folders for the module ' . $moduleName);
            }
        }
    }
}
