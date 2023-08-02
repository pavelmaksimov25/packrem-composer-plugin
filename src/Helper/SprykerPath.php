<?php

namespace SprykerSdk\SprykerFeatureRemover\Helper;

use SprykerSdk\SprykerFeatureRemover\Config\Config;

class SprykerPath
{

    public function __construct(private string $projectNamespace)
    {
    }

    /**
     * @param string $moduleName
     * @return array<string>
     */
    public function getModulePaths(string $moduleName): array
    {
        return array_map(
            fn(string $appLayer): string => "src/$this->projectNamespace/$appLayer/$moduleName",
            Config::APP_LAYERS
        );
    }

    public function getOrmPathForModule(string $moduleName): string
    {
        return 'src/Orm/Zed/' . $moduleName;
    }

    /**
     * @param string $moduleName
     * @return array<string>
     */
    public function getModuleNamespaces(string $moduleName): array
    {
        return array_map(
            fn(string $appLayer): string => "$this->projectNamespace\\$appLayer\\$moduleName",
            Config::APP_LAYERS
        );
    }
}