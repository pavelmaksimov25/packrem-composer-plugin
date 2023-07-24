<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\SprykerFeatureRemover\PluginRemover;

class PluginRemover
{
    /**
     * - Excepts a plugin file name which is the same string that uses in `use` block.
     *   and a list of affected files.
     * - Removes plugin from the method.
     * - Removes class usage from the `use` block.
     *
     * @param string $pluginName
     * @param array $affectedFiles
     *
     * @return mixed
     */
    public function unwirePlugin(string $pluginName, array $affectedFiles): mixed
    {
        foreach ($affectedFiles as $affectedFile) {
            $result = $this->removeFromMethod($pluginName, $affectedFile);
            $result = $this->removeFromUseBlock($pluginName, $affectedFile);
        }

        return false;
    }

    private function removeFromMethod(string $pluginClassName, string $affectedClass): mixed
    {
        return false;
    }

    private function removeFromUseBlock(string $pluginClassName, string $affectedClass): mixed
    {
        return false;
    }
}
