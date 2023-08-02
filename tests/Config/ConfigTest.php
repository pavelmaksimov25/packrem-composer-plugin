<?php

namespace SprykerSdkTests\Config;

use SprykerSdk\SprykerFeatureRemover\Config\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testGetProjectNamespaceReturnsSetValue()
    {
        $projectNamespace = 'Custom';
        $config = new Config($projectNamespace);

        $this->assertSame($projectNamespace, $config->getProjectNamespace());
    }
    public function testGetProjectNamespaceReturnsFallbackValue()
    {
        $config = new Config('');

        $this->assertSame(Config::PROJECT_NAMESPACE_DEFAULT, $config->getProjectNamespace());
    }
}
