<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\Adapter;

class RmModuleDirAdapter
{
    /**
     * @var array<string>
     */
    public const APP_LAYERS = [
        'Client',
        'Glue',
        'Service',
        'Shared',
        'Yves',
        'Zed',
    ];

    public function __construct(private string $projectNamespace)
    {
    }

    public function removeModuleDirectoryFromProjectSrc(string $moduleName): bool
    {
        foreach (static::APP_LAYERS as $appLayer) {
            $path = "src/$this->projectNamespace/$appLayer/$moduleName";
            if (!file_exists($path)) {
                continue;
            }

            if (exec("rm -rf $path") === false) {
                return false;
            }
        }

        return true;
    }

    public function removeModuleDirectoryFromProjectOrm(string $moduleName): bool
    {
        $path = 'src/Orm/Zed/' . $moduleName;
        if (!file_exists($path)) {
            return true;
        }

        return exec("rm -rf $path") !== false;
    }
}
