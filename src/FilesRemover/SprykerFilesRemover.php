<?php

namespace SprykerSdk\SprykerFeatureRemover\FilesRemover;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

class SprykerFilesRemover
{
    public const APP_LAYERS = [
        'Client',
        'Glue',
        'Service',
        'Shared',
        'Yves',
        'Zed',
    ];

    public function __construct(private string $projectNamespace, private Filesystem $filesystem)
    {
    }

    public function removeModuleDirectoryFromProject(string $moduleName): bool
    {
        $pathList = [];
        foreach (self::APP_LAYERS as $appLayer) {
            $pathList[] = "src/$this->projectNamespace/$appLayer/$moduleName";
        }
        try {
            $this->filesystem->remove($pathList);
        } catch (IOException $exception) {
            return false;
        }

        return true;
    }

    public function removeModuleDirectoryFromOrm(string $moduleName): bool
    {
        $path = 'src/Orm/Zed/' . $moduleName;

        try {
            $this->filesystem->remove($path);
        } catch (IOException $exception) {
            return false;
        }

        return true;
    }
}
