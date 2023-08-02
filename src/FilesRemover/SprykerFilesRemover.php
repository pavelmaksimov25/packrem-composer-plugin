<?php

namespace SprykerSdk\SprykerFeatureRemover\FilesRemover;

use SprykerSdk\SprykerFeatureRemover\Helper\SprykerPath;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

class SprykerFilesRemover
{
    public function __construct(private SprykerPath $sprykerPath, private Filesystem $filesystem)
    {
    }

    public function removeModuleDirectoryFromProject(string $moduleName): bool
    {
        try {
            $this->filesystem->remove($this->sprykerPath->getModulePaths($moduleName));
        } catch (IOException $exception) {
            return false;
        }

        return true;
    }

    public function removeModuleDirectoryFromOrm(string $moduleName): bool
    {
        try {
            $this->filesystem->remove($this->sprykerPath->getOrmPathForModule($moduleName));
        } catch (IOException $exception) {
            return false;
        }

        return true;
    }
}
