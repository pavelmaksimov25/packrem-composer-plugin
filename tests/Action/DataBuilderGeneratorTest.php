<?php

namespace SprykerSdkTests\Action;

use PHPUnit\Framework\TestCase;
use SprykerSdk\SprykerFeatureRemover\Action\DataBuilderGenerator;
use SprykerSdk\SprykerFeatureRemover\Adapter\SymfonyProcessAdapter;
use SprykerSdk\SprykerFeatureRemover\Dto\ActionDto;
use SprykerSdk\SprykerFeatureRemover\Dto\ProcessResult;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

class DataBuilderGeneratorTest extends TestCase
{
    public function testActSuccess(): void
    {
        $filesystemMock = $this->createMock(Filesystem::class);
        $filesystemMock->expects($this->once())
            ->method('remove');

        $processAdapterMock = $this->createMock(SymfonyProcessAdapter::class);
        $processAdapterMock->expects($this->once())
            ->method('run')
            ->with(DataBuilderGenerator::COMMAND)
            ->willReturn(new ProcessResult(''));

        $dataBuilderGenerator = new DataBuilderGenerator($filesystemMock, $processAdapterMock);

        $actionDto = new ActionDto();
        $dataBuilderGenerator->act($actionDto);

        $this->assertTrue($actionDto->isOk());
        $this->assertCount(0, $actionDto->getErrorMessages());
    }

    public function testActAddsErrorIfFailedToRemoveGenData(): void
    {
        $filesystemMock = $this->createMock(Filesystem::class);
        $filesystemMock->expects($this->once())
            ->method('remove')
            ->willThrowException(new IOException('Unable to remove.'));

        $processAdapterMock = $this->createMock(SymfonyProcessAdapter::class);
        $processAdapterMock->expects($this->never())
            ->method('run');

        $dataBuilderGenerator = new DataBuilderGenerator($filesystemMock, $processAdapterMock);

        $actionDto = new ActionDto();
        $dataBuilderGenerator->act($actionDto);

        $this->assertFalse($actionDto->isOk());
        $this->assertCount(1, $actionDto->getErrorMessages());
        $this->assertSame('Unable to remove.', $actionDto->getErrorMessages()[0]);
    }

    public function testActAddsErrorIfFailedToExecuteDataBuilderGenerationCommand(): void
    {
        $filesystemMock = $this->createMock(Filesystem::class);
        $filesystemMock->expects($this->once())
            ->method('remove');

        $processAdapterMock = $this->createMock(SymfonyProcessAdapter::class);
        $processAdapterMock->expects($this->once())
            ->method('run')
            ->with(DataBuilderGenerator::COMMAND)
            ->willReturn(new ProcessResult('Unable to execute command.', false));

        $dataBuilderGenerator = new DataBuilderGenerator($filesystemMock, $processAdapterMock);

        $actionDto = new ActionDto();
        $dataBuilderGenerator->act($actionDto);

        $this->assertFalse($actionDto->isOk());
        $this->assertCount(2, $actionDto->getErrorMessages());
        $this->assertSame('`' . DataBuilderGenerator::COMMAND . '` command execution failed. Please run manually.', $actionDto->getErrorMessages()[0]);
        $this->assertSame('Unable to execute command.', $actionDto->getErrorMessages()[1]);
    }
}
