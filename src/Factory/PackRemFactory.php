<?php

namespace SprykerSdk\SprykerFeatureRemover\Factory;

use Composer\Composer;
use SprykerSdk\SprykerFeatureRemover\Action\ActionInterface;
use SprykerSdk\SprykerFeatureRemover\Action\DataBuilderGenerator;
use SprykerSdk\SprykerFeatureRemover\Action\ModuleFolderRemover;
use SprykerSdk\SprykerFeatureRemover\Action\TransferGenerator;
use SprykerSdk\SprykerFeatureRemover\Adapter\ComposerAdapter;
use SprykerSdk\SprykerFeatureRemover\Adapter\SymfonyProcessAdapter;
use SprykerSdk\SprykerFeatureRemover\Config\Config;
use SprykerSdk\SprykerFeatureRemover\Extractor\PackageExtractor;
use SprykerSdk\SprykerFeatureRemover\FilesRemover\SprykerFilesRemover;
use SprykerSdk\SprykerFeatureRemover\PackageRemover\PackageRemover;
use SprykerSdk\SprykerFeatureRemover\Resolver\SprykerModuleResolver;
use SprykerSdk\SprykerFeatureRemover\Validator\PackageValidator;
use Symfony\Component\Filesystem\Filesystem;

final class PackRemFactory
{
    public function __construct(private Config $config) {}

    final public function createPackageRemover(): PackageRemover
    {
        return new PackageRemover([
            $this->createModuleFolderRemoverAction(),
            $this->createTransferGeneratorAction(),
            $this->createDataBuilderGenerator(),
        ]);
    }

    final public function createModuleFolderRemoverAction(): ActionInterface
    {
        return new ModuleFolderRemover($this->createRmDirAdapter());
    }

    final public function createRmDirAdapter(): SprykerFilesRemover
    {
        return new SprykerFilesRemover($this->config->getProjectNamespace(), $this->createFilesystem());
    }

    private function createFilesystem(): Filesystem
    {
        return new Filesystem();
    }

    final public function createTransferGeneratorAction(): ActionInterface
    {
        return new TransferGenerator(
            new Filesystem(),
            new SymfonyProcessAdapter()
        );
    }

    final public function createDataBuilderGenerator(): ActionInterface
    {
        return new DataBuilderGenerator(
            new Filesystem(),
            new SymfonyProcessAdapter()
        );
    }

    final public function createSprykerModuleResolver(): SprykerModuleResolver
    {
        return new SprykerModuleResolver(
            new ComposerAdapter(),
        );
    }

    final public function createPackageExtractor(): PackageExtractor
    {
        return new PackageExtractor();
    }

    final public function createPackageValidator(): PackageValidator
    {
        return new PackageValidator();
    }
}
