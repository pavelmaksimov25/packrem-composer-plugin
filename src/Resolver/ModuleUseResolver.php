<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Resolver;

class ModuleUseResolver
{
    public function resolvePluginsUse(string $moduleName): array
    {
        return []; // TODO :: must return a list of files that contain a dependency to the provided module.
    }
}
