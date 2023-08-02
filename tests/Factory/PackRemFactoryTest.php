<?php

namespace SprykerSdkTests\Factory;

use PHPUnit\Framework\TestCase;
use SprykerSdk\SprykerFeatureRemover\Action\ActionInterface;
use SprykerSdk\SprykerFeatureRemover\Config\Config;
use SprykerSdk\SprykerFeatureRemover\Extractor\PackageExtractor;
use SprykerSdk\SprykerFeatureRemover\Factory\PackRemFactory;
use SprykerSdk\SprykerFeatureRemover\PackageRemover\PackageRemover;
use SprykerSdk\SprykerFeatureRemover\Resolver\SprykerModuleResolver;
use SprykerSdk\SprykerFeatureRemover\Validator\PackageValidator;
class PackRemFactoryTest extends TestCase
{
    public function testCreatePackageRemover(): void
    {
        $factory = new PackRemFactory($this->createConfig());

        $packageRemover = $factory->createPackageRemover();

        $this->assertInstanceOf(PackageRemover::class, $packageRemover);
    }

    public function testCreateModuleFolderRemoverAction(): void
    {
        $factory = new PackRemFactory($this->createConfig());

        $moduleFolderRemoverAction = $factory->createModuleFolderRemoverAction();

        $this->assertInstanceOf(ActionInterface::class, $moduleFolderRemoverAction);
    }

    public function testCreateTransferGeneratorAction(): void
    {
        
        $factory = new PackRemFactory($this->createConfig());

        $transferGeneratorAction = $factory->createTransferGeneratorAction();

        $this->assertInstanceOf(ActionInterface::class, $transferGeneratorAction);
    }

    public function testCreateDataBuilderGenerator(): void
    {
        $factory = new PackRemFactory($this->createConfig());

        $dataBuilderGeneratorAction = $factory->createDataBuilderGenerator();

        $this->assertInstanceOf(ActionInterface::class, $dataBuilderGeneratorAction);
    }

    public function testCreateSprykerModuleResolver(): void
    {
        
        $factory = new PackRemFactory($this->createConfig());

        $sprykerModuleResolver = $factory->createSprykerModuleResolver();

        $this->assertInstanceOf(SprykerModuleResolver::class, $sprykerModuleResolver);
    }

    public function testCreatePackageExtractor(): void
    {
        
        $factory = new PackRemFactory($this->createConfig());

        $packageExtractor = $factory->createPackageExtractor();

        $this->assertInstanceOf(PackageExtractor::class, $packageExtractor);
    }

    public function testCreatePackageValidator(): void
    {
        
        $factory = new PackRemFactory($this->createConfig());

        $packageValidator = $factory->createPackageValidator();

        $this->assertInstanceOf(PackageValidator::class, $packageValidator);
    }

    private function createConfig(): Config
    {
        return new Config('TestPyz');
    }
}
