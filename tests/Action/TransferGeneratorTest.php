<?php

namespace SprykerSdkTests\Action;

use SprykerSdk\SprykerFeatureRemover\Action\TransferGenerator;
use PHPUnit\Framework\TestCase;
use SprykerSdk\SprykerFeatureRemover\Adapter\SymfonyProcessAdapter;
use SprykerSdk\SprykerFeatureRemover\Dto\ActionDto;
use SprykerSdk\SprykerFeatureRemover\Dto\ProcessResult;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

class TransferGeneratorTest extends TestCase
{
    public function testActSuccess(): void
    {
        $filesystemMock = $this->createMock(Filesystem::class);
        $filesystemMock->expects($this->once())
            ->method('remove');

        $processAdapterMock = $this->createMock(SymfonyProcessAdapter::class);
        $processAdapterMock->expects($this->once())
            ->method('run')
            ->with(TransferGenerator::COMMAND)
            ->willReturn(new ProcessResult(''));

        $dataBuilderGenerator = new TransferGenerator($filesystemMock, $processAdapterMock);

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

        $dataBuilderGenerator = new TransferGenerator($filesystemMock, $processAdapterMock);

        $actionDto = new ActionDto();
        $dataBuilderGenerator->act($actionDto);

        $this->assertFalse($actionDto->isOk());
        $this->assertCount(1, $actionDto->getErrorMessages());
        $this->assertContains('Unable to remove.', $actionDto->getErrorMessages());
    }

    public function testActAddsErrorIfFailedToExecuteDataBuilderGenerationCommand(): void
    {
        $filesystemMock = $this->createMock(Filesystem::class);
        $filesystemMock->expects($this->once())
            ->method('remove');

        $processAdapterMock = $this->createMock(SymfonyProcessAdapter::class);
        $processAdapterMock->expects($this->once())
            ->method('run')
            ->with(TransferGenerator::COMMAND)
            ->willReturn(new ProcessResult('Unable to execute command.', false));

        $dataBuilderGenerator = new TransferGenerator($filesystemMock, $processAdapterMock);

        $actionDto = new ActionDto();
        $dataBuilderGenerator->act($actionDto);

        $this->assertFalse($actionDto->isOk());
        $this->assertCount(1, $actionDto->getErrorMessages());
        $this->assertContains(
            'Unable to execute command.',
            $actionDto->getErrorMessages(),
        );
    }
}
