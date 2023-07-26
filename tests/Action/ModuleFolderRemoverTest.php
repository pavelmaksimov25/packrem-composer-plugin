<?php

namespace SprykerSdkTests\Action;

use SprykerSdk\SprykerFeatureRemover\Action\ModuleFolderRemover;
use PHPUnit\Framework\TestCase;
use SprykerSdk\SprykerFeatureRemover\Dto\ActionDto;
use SprykerSdk\SprykerFeatureRemover\FilesRemover\SprykerFilesRemover;

class ModuleFolderRemoverTest extends TestCase
{
    public function testActSuccess(): void
    {
        $moduleName = 'Tax';
        $actionDto = new ActionDto();
        $actionDto->addModuleName($moduleName);
        $sprykerFileRemoverMock = $this->createMock(SprykerFilesRemover::class);
        $sprykerFileRemoverMock->expects($this->once())
            ->method('removeModuleDirectoryFromProject')
            ->with($moduleName)
            ->willReturn(true);

        $sprykerFileRemoverMock->expects($this->once())
            ->method('removeModuleDirectoryFromOrm')
            ->with($moduleName)
            ->willReturn(true);


        $moduleFolderRemover = new ModuleFolderRemover($sprykerFileRemoverMock);
        $moduleFolderRemover->act($actionDto);

        $this->assertTrue($actionDto->isOk());
        $this->assertCount(0, $actionDto->getErrorMessages());
    }

    public function testActReturnsErrorMessageIfRemoveFailed(): void
    {
        $moduleName = 'BornToBeFailed';
        $actionDto = new ActionDto();
        $actionDto->addModuleName($moduleName);
        $sprykerFileRemoverMock = $this->createMock(SprykerFilesRemover::class);
        $sprykerFileRemoverMock->expects($this->once())
            ->method('removeModuleDirectoryFromProject')
            ->with($moduleName)
            ->willReturn(false);

        $sprykerFileRemoverMock->expects($this->once())
            ->method('removeModuleDirectoryFromOrm')
            ->with($moduleName)
            ->willReturn(false);


        $moduleFolderRemover = new ModuleFolderRemover($sprykerFileRemoverMock);
        $moduleFolderRemover->act($actionDto);

        $this->assertFalse($actionDto->isOk());
        $this->assertCount(
            2,
            $actionDto->getErrorMessages(),
        );
        $this->assertContains(
            'Could not delete folders from project for the module ' . $moduleName,
            $actionDto->getErrorMessages()
        );

        $this->assertContains(
            'Could not delete folders from `Orm` folder for the module ' . $moduleName,
            $actionDto->getErrorMessages()
        );
    }
}
