<?php

namespace SprykerSdkTests\FilesRemover;

use SprykerSdk\SprykerFeatureRemover\FilesRemover\SprykerFilesRemover;
use PHPUnit\Framework\TestCase;
use SprykerSdk\SprykerFeatureRemover\Helper\SprykerPath;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

class SprykerFilesRemoverTest extends TestCase
{

    public function testRemoveModuleDirectoryFromProject()
    {
        $sprykerPathMock = $this->createMock(SprykerPath::class);
        $sprykerPathMock->expects($this->once())
            ->method('getModulePaths')
            ->with('Product')
            ->willReturn([
                'src/Pyz/Zed/Product',
                'src/Pyz/Client/Product',
                'src/Pyz/Shared/Product',
                'src/Pyz/Glue/Product',
            ]);

        $fileSystemMock = $this->createMock(Filesystem::class);
        $fileSystemMock->expects($this->once())
            ->method('remove')
            ->with([
                'src/Pyz/Zed/Product',
                'src/Pyz/Client/Product',
                'src/Pyz/Shared/Product',
                'src/Pyz/Glue/Product',
            ]);

        $sprykerFilesRemover = new SprykerFilesRemover($sprykerPathMock, $fileSystemMock);
        $result = $sprykerFilesRemover->removeModuleDirectoryFromProject('Product');

        $this->assertTrue($result);
    }

    public function testRemoveModuleDirectoryReturnsFalseIfIOExceptionThrown(): void
    {
        $sprykerPathMock = $this->createMock(SprykerPath::class);
        $sprykerPathMock->expects($this->once())
            ->method('getModulePaths')
            ->with('Product')
            ->willReturn([
                'src/Pyz/Zed/Product',
                'src/Pyz/Client/Product',
                'src/Pyz/Shared/Product',
                'src/Pyz/Glue/Product',
            ]);

        $fileSystemMock = $this->createMock(Filesystem::class);
        $fileSystemMock->expects($this->once())
            ->method('remove')
            ->willThrowException(new IOException(''));

        $sprykerFilesRemover = new SprykerFilesRemover($sprykerPathMock, $fileSystemMock);
        $result = $sprykerFilesRemover->removeModuleDirectoryFromProject('Product');

        $this->assertFalse($result);
    }

    public function testRemoveModuleDirectoryFromOrm()
    {
        $sprykerPathMock = $this->createMock(SprykerPath::class);
        $sprykerPathMock->expects($this->once())
            ->method('getOrmPathForModule')
            ->with('Product')
            ->willReturn(  'src/Orm/Zed/Product');

        $fileSystemMock = $this->createMock(Filesystem::class);
        $fileSystemMock->expects($this->once())
            ->method('remove')
            ->with('src/Orm/Zed/Product');

        $sprykerFilesRemover = new SprykerFilesRemover($sprykerPathMock, $fileSystemMock);
        $result = $sprykerFilesRemover->removeModuleDirectoryFromOrm('Product');

        $this->assertTrue($result);
    }

    public function testRemoveModuleDirectoryFromOrmReturnsFalseIfIOExceptionThrown()
    {
        $sprykerPathMock = $this->createMock(SprykerPath::class);
        $sprykerPathMock->expects($this->once())
            ->method('getOrmPathForModule')
            ->with('Product')
            ->willReturn(  'src/Orm/Zed/Product');

        $fileSystemMock = $this->createMock(Filesystem::class);
        $fileSystemMock->expects($this->once())
            ->method('remove')
            ->willThrowException(new IOException(''));

        $sprykerFilesRemover = new SprykerFilesRemover($sprykerPathMock, $fileSystemMock);
        $result = $sprykerFilesRemover->removeModuleDirectoryFromOrm('Product');

        $this->assertFalse($result);
    }
}
