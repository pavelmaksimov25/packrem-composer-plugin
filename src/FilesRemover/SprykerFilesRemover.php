<?php

namespace SprykerSdk\SprykerFeatureRemover\FilesRemover;

use _PHPStan_d55c4f2c2\Nette\IOException;
use Symfony\Component\Filesystem\Filesystem;

final class SprykerFilesRemover
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

    public function removeModuleDirectoryFromProjectSrc(string $moduleName): bool
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

    public function removeModuleDirectoryFromProjectOrm(string $moduleName): bool
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
