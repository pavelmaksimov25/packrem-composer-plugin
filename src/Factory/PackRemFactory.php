<?php

namespace SprykerSdk\SprykerFeatureRemover\Factory;

use SprykerSdk\SprykerFeatureRemover\Action\ActionInterface;
use SprykerSdk\SprykerFeatureRemover\Action\DataBuilderGenerator;
use SprykerSdk\SprykerFeatureRemover\Action\ModuleFolderRemover;
use SprykerSdk\SprykerFeatureRemover\Action\TransferGenerator;
use SprykerSdk\SprykerFeatureRemover\Adapter\RmModuleDirAdapter;
use SprykerSdk\SprykerFeatureRemover\Config\Config;
use SprykerSdk\SprykerFeatureRemover\PackageRemover\PackageRemover;

final class PackRemFactory
{
    public final function createPackageRemover(): PackageRemover
    {
        return new PackageRemover([
            $this->createModuleFolderRemoverAction(),
            $this->createTransferGeneratorAction(),
            $this->createDataBuilderGenerator(),
        ]);
    }

    public final function createModuleFolderRemoverAction(): ActionInterface
    {
        return new ModuleFolderRemover($this->createRmDirAdapter());
    }

    public final function createRmDirAdapter(): RmModuleDirAdapter
    {
        return new RmModuleDirAdapter((new Config())->getProjectNamespace());
    }

    public final function createTransferGeneratorAction(): ActionInterface
    {
        return new TransferGenerator();
    }

    public final function createDataBuilderGenerator(): ActionInterface
    {
        return new DataBuilderGenerator();
    }
}