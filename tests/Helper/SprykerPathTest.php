<?php

namespace SprykerSdkTests\Helper;

use SprykerSdk\SprykerFeatureRemover\Config\Config;
use SprykerSdk\SprykerFeatureRemover\Helper\SprykerPath;
use PHPUnit\Framework\TestCase;

class SprykerPathTest extends TestCase
{

    public function testGetModuleNamespaces()
    {
        $module = 'Product';
        $expectedResult = [
            'Pyz\\Client\\Product',
            'Pyz\\Glue\\Product',
            'Pyz\\Service\\Product',
            'Pyz\\Shared\\Product',
            'Pyz\\Yves\\Product',
            'Pyz\\Zed\\Product',
        ];

        $sprykerPath = new SprykerPath(Config::PROJECT_NAMESPACE_DEFAULT);
        $namespaces = $sprykerPath->getModuleNamespaces($module);

        $this->assertSame(
            $expectedResult,
            $namespaces,
        );
    }

    public function testGetModulePaths()
    {
        $module = 'Product';
        $expectedResult = [
            'src/Pyz/Client/Product',
            'src/Pyz/Glue/Product',
            'src/Pyz/Service/Product',
            'src/Pyz/Shared/Product',
            'src/Pyz/Yves/Product',
            'src/Pyz/Zed/Product',
        ];

        $sprykerPath = new SprykerPath(Config::PROJECT_NAMESPACE_DEFAULT);
        $result = $sprykerPath->getModulePaths($module);

        $this->assertSame($expectedResult, $result);
    }

    public function testGetOrmPathForModule()
    {
        $module = 'Product';
        $expectedResult = 'src/Orm/Zed/Product';

        $sprykerPath = new SprykerPath(Config::PROJECT_NAMESPACE_DEFAULT);
        $result = $sprykerPath->getOrmPathForModule($module);

        $this->assertSame($expectedResult, $result);
    }
}
